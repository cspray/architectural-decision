<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\BadAdr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * The contents of the ADR
 */
#[Attribute(Attribute::TARGET_ALL)]
final class MissingRequiredTagsDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}