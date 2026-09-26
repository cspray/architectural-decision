<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date 2026-01-01
 * @status Accepted
 * @author Harry
 * @author
 * @author Mack
 */
#[Attribute(Attribute::TARGET_ALL)]
final class EmptyMultipleAuthorTagDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}