<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * Another doc block.
 */
#[Attribute(Attribute::TARGET_ALL)]
final class AnotherDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function id() : string {
        return 'Another DocBlock';
    }

    public function date() : DateTimeImmutable {
        return new DateTimeImmutable('1984-01-01', new \DateTimeZone('America/New_York'));
    }

    public function status() : string {
        return 'Draft';
    }
}