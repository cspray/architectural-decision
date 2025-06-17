<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\ExplicitArchitecturalDecisionStatus;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\PreferCustomArchitecturalDecisionOverGeneric;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\UsingAttributesForArchitecturalDecisions;
use DateTimeImmutable;

#[ExplicitArchitecturalDecisionStatus]
#[PreferCustomArchitecturalDecisionOverGeneric]
#[UsingAttributesForArchitecturalDecisions]
interface ArchitecturalDecisionRecord {

    public function id() : DecisionId;

    public function date() : DateTimeImmutable;

    /**
     * @return non-empty-list<DecisionAuthor>
     */
    public function authors() : array;

    public function status() : DecisionStatus;

    public function contents() : DecisionContents;

    /**
     * @return list<DecisionMetaData>
     */
    public function metaData() : array;

}