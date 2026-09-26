<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * This is a DocBlock explaining an architectural decision.
 *
 * This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
 * displayed in the CLI tool explaining the reason for the Architectural Decision.
 *
 * @date 2022-01-01
 * @status Accepted
 * @author Charles Sprayberry
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}
