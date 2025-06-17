<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionMetaDataProperty::class)]
final class DecisionMetaDataPropertyTest extends TestCase {

    public function testKeyValueHasCorrectData() : void {
        $subject = DecisionMetaDataProperty::keyValue('key', 'value');

        self::assertSame('key', $subject->key);
        self::assertSame('value', $subject->value);
    }

}