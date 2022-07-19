<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * Another doc block.
 */
#[Attribute(Attribute::TARGET_ALL)]
final class AnotherDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function getTitle() : string {
        return 'Another DocBlock';
    }

    public function getDate() : string {
        return '1984-01-01';
    }
}