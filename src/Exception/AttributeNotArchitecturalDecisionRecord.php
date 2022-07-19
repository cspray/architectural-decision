<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord;

final class AttributeNotArchitecturalDecisionRecord extends Exception {

    /**
     * @param class-string $type
     */
    public static function invalidAttributeType(string $type) : self {
        return new self(
            sprintf('The Attribute %s MUST implement %s.', $type, ArchitecturalDecisionRecord::class)
        );
    }

}