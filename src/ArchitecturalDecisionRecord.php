<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\ExplicitArchitecturalDecisionStatus;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\PreferCustomArchitecturalDecisionOverGeneric;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\UsingAttributesForArchitecturalDecisions;

#[ExplicitArchitecturalDecisionStatus]
#[PreferCustomArchitecturalDecisionOverGeneric]
#[UsingAttributesForArchitecturalDecisions]
interface ArchitecturalDecisionRecord {

    public function getTitle() : string;

    public function getDate() : string;

    public function getStatus() : string;

    public function getContents() : string;

}