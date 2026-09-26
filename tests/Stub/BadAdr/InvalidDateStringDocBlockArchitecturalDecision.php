<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date Not a valid date string at all
 * @status Draft
 * @author Charles Sprayberry
 */
#[\Attribute(\Attribute::TARGET_ALL)]
final class InvalidDateStringDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {

}