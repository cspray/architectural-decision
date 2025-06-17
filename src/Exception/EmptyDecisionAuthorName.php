<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

final class EmptyDecisionAuthorName extends Exception {

    public static function fromEmptyNameForAuthor() : self {
        return new self(
            'Architectural Decision Records author names MUST be a non-empty string'
        );
    }

}