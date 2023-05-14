<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

abstract class Initializer {

    final public function __construct() {}

    /**
     * @return list<non-empty-string>
     */
    abstract public function getAdditionalScanPaths() : array;

}
