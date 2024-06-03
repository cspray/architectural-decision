<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DOMElement;

/**
 * I load meta data.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class StubMetaDataArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function getDate() : string {
        return '2022-07-20';
    }

    public function getStatus() : string|DecisionStatus {
        return DecisionStatus::Draft;
    }

    public function setMetaData(DOMElement $meta) : void {
        $dom = $meta->ownerDocument;

        $foo = $meta->appendChild(
            $dom->createElement('foo')
        );

        $foo->appendChild(
            $dom->createElement('bar', 'baz')
        );

        $keywords = $meta->appendChild(
            $dom->createElement('baz')
        );

        $keywords->appendChild(
            $dom->createElement('qux', 'code it is')
        );
    }
}