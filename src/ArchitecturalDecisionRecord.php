<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\UsingAttributesForArchitecturalDecisions;

#[UsingAttributesForArchitecturalDecisions]
interface ArchitecturalDecisionRecord {

    public function getTitle() : string;

    public function getDate() : string;

    public function getContents() : string;

}