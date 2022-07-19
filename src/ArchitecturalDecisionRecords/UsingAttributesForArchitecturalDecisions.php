<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * Architectural Decision Records (ADR) can be useful in determining why a piece of software is the way it is. While
 * these type of documents can live anywhere, an Attribute in your codebase can be a good place to store this info.
 * For more information, please check out the README in this repo or at https://github.com/cspray/architectural-decision
 */
#[Attribute(Attribute::TARGET_ALL)]
final class UsingAttributesForArchitecturalDecisions extends DocBlockArchitecturalDecision {
    public function getTitle() : string {
        return 'Use Attributes for Architectural Decision Records';
    }

    public function getDate() : string {
        return '2022-07-19';
    }
}