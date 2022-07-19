<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * It is preferred to create a custom Attribute per decision over implementing a generic Attribute to handle many
 * decisions.
 *
 * One of the earliest decisions in the design of this library was to have the supported use case be a custom Attribute
 * per decision and to discourage the use of a generic attribute, e.g. #[ADR('Title', '2022-07-19', 'Reasonining')]. On
 * the surface a generic Attribute has some advantages, there are also drawbacks that make them a poor solution for what
 * this library is trying to accomplish. Specifically, there are 2 primary concerns with the generic Attribute approach:
 *
 * 1. Generic Attributes increase the likelihood that you'll have to repeat information and that errors/typos are
 * introduced. If you use a generic Attribute then every place that you use that Attribute in your codebase must also
 * include all the relevant information. This could easily turn problematic if the same ADR has different state in each
 * place it is attributed. The decision details should be documented in one, canonical place and not spread across your
 * codebase.
 *
 * 2. Generic Attributes do not facilitate static analysis. Having an explicit type for each decision allows for static
 * analysis tools to more easily infer information about each use of the Attribute. A generic Attribute for all decisions
 * would lose the ability to infer this information as you're now much more dependent on the value of the Attribute
 * instead of the type to infer which decision it refers to.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class PreferCustomArchitecturalDecisionOverGeneric extends DocBlockArchitecturalDecision {

    public function getTitle() : string {
        return 'Prefer Custom Attributes Over Generic';
    }

    public function getDate() : string {
        return '2022-07-19';
    }

    public function getStatus() : string {
        return 'Draft';
    }
}