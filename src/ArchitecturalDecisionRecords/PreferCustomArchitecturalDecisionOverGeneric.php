<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * It is preferred to create a custom Attribute per decision over implementing a generic Attribute to handle many
 * decisions.
 *
 * ## Problem Description
 *
 * As a developer using Architectural Decision I would like to use a generic Attribute to define an Architectural Decision
 * Record instead of having to implement a custom Attribute unique to each decision.
 *
 * ## Decision
 *
 * One of the earliest decisions in the design of this library was to have the supported use case be a custom Attribute
 * per ADR and to discourage the use of a generic attribute, e.g. #[ADR('Title', '2022-07-19', 'Reasoning')]. On the
 * surface a generic Attribute has some advantages, there are also drawbacks that make them a poor solution for what
 * this library is trying to accomplish. Specifically, I identify 3 problems with the generic Attribute approach.
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
 *
 * 3. Generic Attributes require more information to construct them correctly. This concern is meant to address a specific
 * technical limitation and/or requirement. We cannot rely strictly on an Attribute instance to know what ADR are available
 * and to generate information about them. For example, you introduce an ADR but do not add a corresponding Attribute
 * annotation anywhere. In this case there's no Attribute instance to gather but the decision should still be listed in
 * the generated XML document, simply with no <codeAnnotations></codeAnnotations> element present. This is a valid use
 * case and should be supported out-the-box. This limitation could be partly lifted from a technical level by introducing
 * a factory to create an ArchitecturalDecisionRecord instead of relying on a dependency-free constructor. However, with
 * the other limitations facing a generic Attribute approach I'd rather encourage following conventions.
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
        return 'Accepted';
    }
}