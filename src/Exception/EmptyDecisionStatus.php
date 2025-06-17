<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

final class EmptyDecisionStatus extends Exception {

    public static function fromEmptyStatusProvided() : self {
        return new self(
            'An Architectural Decision Record status MUST be a non-empty string'
        );
    }

}