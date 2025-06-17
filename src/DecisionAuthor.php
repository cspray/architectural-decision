<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\EmptyDecisionAuthorName;

final readonly class DecisionAuthor {

    /**
     * @param non-empty-string $name
     */
    private function __construct(
        public string $name,
    ) {}

    public static function fromName(string $name) : self {
        if (trim($name) === '') {
            throw EmptyDecisionAuthorName::fromEmptyNameForAuthor();
        }

        /** @psalm-var non-empty-string $name */
        return new self($name);
    }

}