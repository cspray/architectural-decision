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

    public function id() : string {
        return 'stub-attr-id';
    }

    public function date() : \DateTimeImmutable {
        return new \DateTimeImmutable('2022-01-01', new \DateTimeZone('America/New_York'));
    }

    public function status() : DecisionStatus {
        return DecisionStatus::Accepted;
    }
}