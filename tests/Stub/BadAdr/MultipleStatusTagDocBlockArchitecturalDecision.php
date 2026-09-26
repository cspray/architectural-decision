<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date 2025-01-01
 * @status Draft
 * @status Accepted
 * @author Charles Sprayberry
 */
#[Attribute(Attribute::TARGET_ALL)]
final class MultipleStatusTagDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}