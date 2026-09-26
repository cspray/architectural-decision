<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DocBlock\ClassDocBlock;
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
    public static function fromClassLevelDocBlock(ClassDocBlock $docBlock) : self {
        if (!is_a($docBlock->class, ArchitecturalDecisionRecord::class, true)) {
            throw InvalidDocBlockArchitecturalDecision::fromDocBlockClassNotArchitecturalDecisionRecord($docBlock->class);
        }

        if ($docBlock->contents === null) {
            throw InvalidDocBlockArchitecturalDecision::fromArchitecturalDecisionRecordHasNoDocBlock($docBlock->class);
        }

        return self::fromString($docBlock->contents);
    }

}
