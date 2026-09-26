<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionMetaData;
use Cspray\ArchitecturalDecision\DecisionMetaDataProperty;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * Boilerplate markdown content.
 *
 * @date 2025-06-11
 * @status Accepted
 * @author Charles Sprayberry
 * @foo bar
 * @propOne one prop value
 * @prop-two two prop value
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubWithMetaDataArchitecturalDecision extends DocBlockArchitecturalDecision {}