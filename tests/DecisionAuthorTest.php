<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DataProvider\GenericStringProvider;
use Cspray\ArchitecturalDecision\Exception\EmptyDecisionAuthorName;
use Cspray\ArchitecturalDecision\Exception\Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionAuthor::class)]
#[CoversClass(EmptyDecisionAuthorName::class)]
#[UsesClass(Exception::class)]
final class DecisionAuthorTest extends TestCase {

    #[DataProviderExternal(GenericStringProvider::class, 'emptyStringProvider')]
    public function testEmptyNameThrowsException(string $name) : void {
        $this->expectException(EmptyDecisionAuthorName::class);
        $this->expectExceptionMessage('Architectural Decision Records author names MUST be a non-empty string');

        DecisionAuthor::fromName($name);
    }

    public function testNonEmptyNameHasCorrectValueAvailable() : void {
        $subject = DecisionAuthor::fromName('Charles');

        self::assertSame('Charles', $subject->name);
    }

}