<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord;
use Throwable;

final class InvalidDocBlockArchitecturalDecision extends Exception {

    public readonly array $validationFailures;

    protected function __construct(string $message, array $validationFailures) {
        parent::__construct($message);
        $this->validationFailures = $validationFailures;
    }

    public static function fromDocBlockClassNotArchitecturalDecisionRecord(string $class) : self {
        return new self(
            sprintf(
                'Architectural Decision Records derived from a doc block MUST implement %s, but %s does not',
                ArchitecturalDecisionRecord::class,
                $class,
            ),
            [],
        );
    }

    public static function fromArchitecturalDecisionRecordHasNoDocBlock(string $class) : self {
        return new self(
            sprintf(
                'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
                . '%s does not',
                $class
            ),
            [],
        );
    }

    public static function fromArchitecturalDecisionRecordDoesNotHaveRequiredTags(
        string $class,
        array $validationFailures,
    ) : self {
        return new self(
            sprintf(
                'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
                . '%s does not',
                $class,
            ),
            $validationFailures,
        );
    }

}
