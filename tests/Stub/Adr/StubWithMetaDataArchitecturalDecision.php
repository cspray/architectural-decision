<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Stub\Adr;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionMetaData;
use Cspray\ArchitecturalDecision\DecisionMetaDataProperty;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * Boilerplate markdown content.
 */
#[Attribute(Attribute::TARGET_ALL)]
final class StubWithMetaDataArchitecturalDecision extends DocBlockArchitecturalDecision {

    public function __construct() {
        parent::__construct(
            new DateTimeImmutable('2025-06-11', new \DateTimeZone('America/New_York')),
            DecisionStatus::accepted(),
            [DecisionAuthor::fromName('Charles Sprayberry')],
            [
                DecisionMetaData::keyValue('foo', 'bar'),
                DecisionMetaData::keyValueWithProperties('with-properties', 42, [
                    DecisionMetaDataProperty::keyValue('prop-one', 'prop-one-value'),
                    DecisionMetaDataProperty::keyValue('prop-two', 'prop-two-value'),
                ]),
            ]
        );
    }

}