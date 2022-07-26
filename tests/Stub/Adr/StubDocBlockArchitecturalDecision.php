<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * This is a DocBlock explaining an architectural decision.
 *
 * This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
 * displayed in the CLI tool explaining the reason for the Architectural Decision.
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function getId() : string {
        return 'stub-attr-id';
    }

    public function getDate() : string {
        return '2022-01-01';
    }

    public function getStatus() : DecisionStatus {
        return DecisionStatus::Accepted;
    }
}