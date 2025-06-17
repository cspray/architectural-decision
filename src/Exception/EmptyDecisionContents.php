<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

final class EmptyDecisionContents extends Exception {

   public static function fromEmptyDecisionContentsProvided() : self {
        return new self('Architectural Decision Records contents MUST be a non-empty string');
   }

}