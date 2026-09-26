<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;

/**
 * Some content that does not matter in the context of this stub.
 *
 * @date 2026-09-26
 * @status Accepted
 * @author Mack
 * @author Ellie
 * @author Nick
 * @author Kate
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubWithMultipleAuthorDocBlockArchitecturalDecision extends DocBlockArchitecturalDecision {}