<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DataProvider\GenericStringProvider;
use Cspray\ArchitecturalDecision\Exception\EmptyDecisionId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionId::class)]
#[CoversClass(EmptyDecisionId::class)]
final class DecisionIdTest extends TestCase {

    #[DataProviderExternal(GenericStringProvider::class, 'emptyStringProvider')]
    public function testBlankDecisionIdThrowsException(string $badId) : void {
        $this->expectException(EmptyDecisionId::class);
        $this->expectExceptionMessage(
            'An Architectural Decision Record ID MUST be a non-empty string'
        );

        DecisionId::fromUniqueString($badId);
    }

    public function testValidDecisionIdReturnsCorrectValueFromToString() : void {
        $id = DecisionId::fromUniqueString('my id');

        self::assertSame('my id', $id->value);
    }

    public function testDecisionIdAreNotSameDoNotEqualOneAnother() : void {
        $a = DecisionId::fromUniqueString('a');

        self::assertFalse($a->equals(DecisionId::fromUniqueString('b')));
    }

    public function testDecisionIdAreSameDoEqualOneAnother() : void {
        $foo = DecisionId::fromUniqueString('foo');

        self::assertTrue($foo->equals(DecisionId::fromUniqueString('foo')));
    }

}