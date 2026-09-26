<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date
 * @status Draft
 * @author Charles Sprayberry
 */
#[Attribute(Attribute::TARGET_ALL)]
final class EmptyDateTagDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

}