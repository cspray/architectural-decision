<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

#[Attribute(Attribute::TARGET_ALL)]
final class MissingDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function getTitle() : string {
        return 'Missing DocBlock';
    }

    public function getDate() : string {
        return '2016-01-01';
    }

    public function getStatus() : string {
        return 'Rejected';
    }
}