<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;
use DOMElement;

/**
 * I load meta data.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class StubMetaDataArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function date() : DateTimeImmutable {
        return new DateTimeImmutable('2022-07-20', new \DateTimeZone('America/New_York'));
    }

    public function status() : string|DecisionStatus {
        return DecisionStatus::Draft;
    }

    public function addMetaData(DOMElement $meta) : void {
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