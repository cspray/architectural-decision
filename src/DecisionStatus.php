<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

enum DecisionStatus : string {
    case Accepted = 'Accepted';
    case Rejected = 'Rejected';
    case Draft = 'Draft';
    case WorkingDraft = 'Draft - Working';
    case Superseded = 'Superseded';

}