<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\ExplicitArchitecturalDecisionStatus;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\PreferCustomArchitecturalDecisionOverGeneric;
use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords\UsingAttributesForArchitecturalDecisions;
use DateTimeImmutable;
use DOMElement;

#[ExplicitArchitecturalDecisionStatus]
#[PreferCustomArchitecturalDecisionOverGeneric]
#[UsingAttributesForArchitecturalDecisions]
interface ArchitecturalDecisionRecord {

    const SCHEMA = 'https://architectural-decision.cspray.io/schema/architectural-decision.xsd';

    public function id() : string;

    public function date() : DateTimeImmutable;

    public function status() : string|DecisionStatus;

    public function contents() : string;

    public function addMetaData(DOMElement $meta) : void;

}