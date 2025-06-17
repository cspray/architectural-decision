<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\SupportedDecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * This is a DocBlock explaining an architectural decision.
 *
 * This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
 * displayed in the CLI tool explaining the reason for the Architectural Decision.
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function __construct() {
        parent::__construct(
            new \DateTimeImmutable('2022-01-01', new \DateTimeZone('America/New_York')),
            DecisionStatus::accepted(),
            [DecisionAuthor::fromName('Charles Sprayberry')]
        );
    }

}
