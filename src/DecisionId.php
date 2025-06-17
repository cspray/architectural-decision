<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\EmptyDecisionId;

final readonly class DecisionId {

    /**
     * @param non-empty-string $value
     */
    private function __construct(
        public string $value
    ) {}

    public static function fromUniqueString(string $id) : self {
        if (trim($id) === '') {
            throw EmptyDecisionId::fromEmptyDecisionIdProvided();
        }

        /** @psalm-var non-empty-string $id */
        return new self($id);
    }

    public function equals(DecisionId $decisionId) : bool {
        return $this->value === $decisionId->value;
    }

}
