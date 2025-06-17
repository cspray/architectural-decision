<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\EmptyDecisionContents;
use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;

final readonly class DecisionContents {

    /**
     * @param non-empty-string $value
     */
    private function __construct(
        public string $value,
    ) {}

    public static function fromString(string $contents) : self {
        if (trim($contents) === '') {
            throw EmptyDecisionContents::fromEmptyDecisionContentsProvided();
        }

        /** @psalm-var non-empty-string $contents */
        return new self($contents);
    }

    /**
     * @throws EmptyDecisionContents
     * @throws InvalidDocBlockArchitecturalDecision
     */
    public static function fromClassLevelDocBlock(string $fqcn) : self {
        if (!class_exists($fqcn)) {
            throw InvalidDocBlockArchitecturalDecision::fromDocBlockAdrNotClass($fqcn);
        }

        if (!is_a($fqcn, ArchitecturalDecisionRecord::class, true)) {
            throw InvalidDocBlockArchitecturalDecision::fromDocBlockClassNotArchitecturalDecisionRecord($fqcn);
        }

        $reflection = new \ReflectionClass($fqcn);
        $docBlock = $reflection->getDocComment();

        if ($docBlock === false) {
            throw InvalidDocBlockArchitecturalDecision::fromArchitecturalDecisionRecordHasNoDocBlock($fqcn);
        }

        $parts = explode(PHP_EOL, $docBlock);
        array_shift($parts);
        array_pop($parts);

        foreach ($parts as $index => $part) {
            $parts[$index] = ltrim($part, ' *');
        }

        $contents = implode(PHP_EOL, $parts);

        return self::fromString($contents);
    }

}
