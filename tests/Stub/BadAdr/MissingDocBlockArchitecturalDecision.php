<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

#[Attribute(Attribute::TARGET_ALL)]
final class MissingDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function date() : DateTimeImmutable {
        return new DateTimeImmutable('2016-01-01', new \DateTimeZone('America/New_York'));
    }

    public function status() : string {
        return 'Rejected';
    }
}