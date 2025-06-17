<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\EmptyDecisionStatus;

final readonly class DecisionStatus {

    /**
     * @param non-empty-string $value
     */
    private function __construct(
        public string $value
    ) {}

    public static function fromCustomStatus(string $status) : self {
        if (trim($status) === '') {
            throw EmptyDecisionStatus::fromEmptyStatusProvided();
        }

        /** @psalm-var non-empty-string $status */
        return new self($status);
    }

    public static function accepted() : self {
        return new self('Accepted');
    }

    public static function rejected() : self {
        return new self('Rejected');
    }

    public static function draft() : self {
        return new self('Draft');
    }

    public static function workingDraft() : self {
        return new self('Draft - Working');
    }

    public static function superseded() : self {
        return new self('Superseded');
    }

    public function equals(DecisionStatus $status) : bool {
        return $this->value === $status->value;
    }

}