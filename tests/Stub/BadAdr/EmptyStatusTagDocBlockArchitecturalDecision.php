<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date 2026-09-26
 * @status
 * @author Charles Sprayberry
 */
#[Attribute(Attribute::TARGET_ALL)]
final class EmptyStatusTagDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}