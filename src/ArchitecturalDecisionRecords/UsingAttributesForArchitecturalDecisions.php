<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlock\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * # Use Attributes for Architectural Decisions
 *
 * Architectural Decision Records (ADR) can be useful in determining why a piece of software is the way it is. While
 * these type of documents can live anywhere, an Attribute in your codebase can be a good place to store this info.
 * For more information, please check out the README in this repo or at https://github.com/cspray/architectural-decision
 *
 * @date 2022-07-19
 * @status Accepted
 * @author Charles Sprayberry
 */
#[Attribute(Attribute::TARGET_ALL)]
final class UsingAttributesForArchitecturalDecisions extends DocBlockArchitecturalDecision {}
