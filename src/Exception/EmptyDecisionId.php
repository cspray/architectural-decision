<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

final class EmptyDecisionId extends Exception {

    public static function fromEmptyDecisionIdProvided() : self {
        return new self(
            'An Architectural Decision Record ID MUST be a non-empty string'
        );
    }

}