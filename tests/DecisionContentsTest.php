<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DataProvider\GenericStringProvider;
use Cspray\ArchitecturalDecision\DocBlock\ClassDocBlock;
use Cspray\ArchitecturalDecision\DocBlock\Tags;
use Cspray\ArchitecturalDecision\Exception\EmptyDecisionContents;
use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use Cspray\AssertThrows\ThrowableAssertTestCaseMethods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(DecisionContents::class)]
#[CoversClass(EmptyDecisionContents::class)]
#[CoversClass(InvalidDocBlockArchitecturalDecision::class)]
#[UsesClass(ClassDocBlock::class)]
#[UsesClass(Tags::class)]
final class DecisionContentsTest extends TestCase {

    use ThrowableAssertTestCaseMethods;

    #[DataProviderExternal(GenericStringProvider::class, 'emptyStringProvider')]
    public function testEmptyContentsThrowsException(string $contents) : void {
        $this->expectException(EmptyDecisionContents::class);
        $this->expectExceptionMessage('Architectural Decision Records contents MUST be a non-empty string');

        DecisionContents::fromString($contents);
    }

    public function testValidContentsAreReturnedAppropriately() : void {
        $subject = DecisionContents::fromString('the contents of the decision');

        self::assertSame('the contents of the decision', $subject->value);
    }

    public function testDocBlockDecisionIsNotArchitecturalDecisionRecordThrowsException() : void {
        $throwable = self::assertThrowsExceptionTypeWithMessage(
            static fn() => DecisionContents::fromClassLevelDocBlock(
                ClassDocBlock::fromReflection(new ReflectionClass(self::class))
            ),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST implement '
            . ArchitecturalDecisionRecord::class . ', but ' . self::class . ' does not',
        );
        self::assertSame([], $throwable->validationFailures);
    }

    public function testDocBlockDecisionDoesNotHaveDocBlockThrowsException() : void {
        $this->expectException(InvalidDocBlockArchitecturalDecision::class);
        $this->expectExceptionMessage(
            'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
            . MissingDocBlockArchitecturalDecision::class . ' does not'
        );

        DecisionContents::fromClassLevelDocBlock(
            ClassDocBlock::fromReflection(
                new ReflectionClass(MissingDocBlockArchitecturalDecision::class)
            ),
        );
    }

    public function testDocBlockPresentHasCorrectContents() : void {
        $contents = DecisionContents::fromClassLevelDocBlock(
            ClassDocBlock::fromReflection(
                new ReflectionClass(StubDocBlockArchitecturalDecision::class),
            ),
        );

        $expected = <<<TEXT
        This is a DocBlock explaining an architectural decision.
        
        This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
        displayed in the CLI tool explaining the reason for the Architectural Decision.
        TEXT;

        self::assertSame($expected, $contents->value);
    }


}