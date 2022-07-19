<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\Typiphy\ObjectType;

interface ArchitecturalDecisionAttributeRegistry {

    /**
     * @return list<ObjectType>
     */
    public function getArchitecturalDecisionAttributes() : array;

}