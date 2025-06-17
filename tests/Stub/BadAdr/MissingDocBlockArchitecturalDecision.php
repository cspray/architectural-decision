<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

#[Attribute(Attribute::TARGET_ALL)]
final class MissingDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function __construct() {
        parent::__construct(
            new DateTimeImmutable('2016-01-01', new \DateTimeZone('America/New_York')),
            DecisionStatus::rejected(),
            [DecisionAuthor::fromName('Charles Sprayberry')]
        );
    }

}