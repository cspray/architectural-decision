<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord;

final class DuplicateArchitecturalDecisionRecord extends Exception {

    public static function fromAdrWithDecisionIdAlreadyAddedToCollection(ArchitecturalDecisionRecord $duplicate) : self {
        return new self(sprintf(
            'An Architectural Decision Record MUST have a unique ID, but multiple records were found with id "%s"',
            $duplicate->id()->value
        ));
    }

}