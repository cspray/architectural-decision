<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionMetaData::class)]
#[UsesClass(DecisionMetaDataProperty::class)]
final class DecisionMetaDataTest extends TestCase {

    public function testKeyValueMetaDataHasCorrectDataAndNoProperties() : void {
        $subject = DecisionMetaData::keyValue('key', 'value');

        self::assertSame('key', $subject->key);
        self::assertSame('value', $subject->value);
        self::assertSame([], $subject->properties);
    }

    public function testKeyValueWithPropertiesHasCorrectDataAndProperties() : void {
        $subject = DecisionMetaData::keyValueWithProperties(
            'deprecated', true, [
                $since = DecisionMetaDataProperty::keyValue('since', '0.1.0')
            ]
        );

        self::assertSame('deprecated', $subject->key);
        self::assertTrue($subject->value);
        self::assertSame([$since], $subject->properties);
    }


}