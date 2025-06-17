<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord;

final class InvalidDocBlockArchitecturalDecision extends Exception {

    public static function fromDocBlockAdrNotClass(string $value) : self {
        return new self(sprintf(
            'Architectural Decision Records derived from a doc block MUST come from a loadable class, '
            . 'but "%s" is not a class',
            $value
        ));
    }

    public static function fromDocBlockClassNotArchitecturalDecisionRecord(string $class) : self {
        return new self(sprintf(
            'Architectural Decision Records derived from a doc block MUST implement %s, but %s does not',
            ArchitecturalDecisionRecord::class,
            $class,
        ));
    }

    public static function fromArchitecturalDecisionRecordHasNoDocBlock(string $class) : self {
        return new self(sprintf(
            'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
            . '%s does not',
            $class
        ));
    }

}