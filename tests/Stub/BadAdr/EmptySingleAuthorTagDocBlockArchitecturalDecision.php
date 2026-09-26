<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * ADR contents
 *
 * @date 1970-01-01
 * @status Accepted
 * @author
 */
#[Attribute(Attribute::TARGET_ALL)]
final class EmptySingleAuthorTagDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}