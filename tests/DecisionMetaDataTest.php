<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionMetaData::class)]
final class DecisionMetaDataTest extends TestCase {
    public function testKeyValueMetaDataHasCorrectDataAndNoProperties() : void {
        $subject = DecisionMetaData::keyValue('key', 'value');

        self::assertSame('key', $subject->key);
        self::assertSame('value', $subject->value);
    }
}