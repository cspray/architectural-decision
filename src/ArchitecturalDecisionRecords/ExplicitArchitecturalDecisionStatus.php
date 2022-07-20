<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;

/**
 * # Explicit Architectural Decision Status
 *
 * An explicit status should be provided for each ArchitecturalDecisionRecord instead of relying on an implicit status,
 * e.g. the presence of the ADR in your project's main branch.
 *
 * ## Problem Description
 *
 * As a developer I would like for the inclusion of my ADR in a default branch, or some other by-convention mechanism, to
 * implicitly determine that ADR's status.
 *
 * ## Decision
 *
 * Some libraries may be able to take advantage of an implicit, by-convention approach to statuses. If possible, it is
 * encouraged to do so by implementing your own abstract ArchitecturalDecisionRecord that defines the statuses for all
 * decisions according to your conventions.
 *
 * Other projects might require more complete processes around the status of a decision. For example, a 'Draft - Working'
 * status for complex decisions to see how they impact the codebase and team over time. Previously 'Accepted' decisions
 * could become 'Deprecated' or 'Rejected' outright. In those situations leaving the decision in place, while removing
 * annotations using the Attribute, could be the preferred approach. This way, why the previously accepted decision is
 * no longer valid stays in the history of the codebase instead of being removed. Or, perhaps you use the 'Deprecated'
 * status of the decision to find code locations that are in need of refactoring.
 *
 * Requiring an explicit status enables both workflows; having an implicit status is still supported by providing your
 * own implementation logic and explicit statuses are also supported. Only having an implicit status would not allow
 * for both workflows.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class ExplicitArchitecturalDecisionStatus extends DocBlockArchitecturalDecision {

    public function getDate() : string {
        return '2022-07-19';
    }

    public function getStatus() : DecisionStatus {
        return DecisionStatus::Accepted;
    }
}