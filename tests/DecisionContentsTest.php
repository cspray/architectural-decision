<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DataProvider\GenericStringProvider;
use Cspray\ArchitecturalDecision\Exception\EmptyDecisionContents;
use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionContents::class)]
#[CoversClass(EmptyDecisionContents::class)]
#[CoversClass(InvalidDocBlockArchitecturalDecision::class)]
final class DecisionContentsTest extends TestCase {

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

    public function testDocBlockDecisionIsNotClassThrowsException() : void {
        $this->expectException(InvalidDocBlockArchitecturalDecision::class);
        $this->expectExceptionMessage(
            'Architectural Decision Records derived from a doc block MUST come from a loadable class, but '
            . '"not a class" is not a class'
        );

        DecisionContents::fromClassLevelDocBlock('not a class');
    }

    public function testDocBlockDecisionIsNotArchitecturalDecisionRecordThrowsException() : void {
        $this->expectException(InvalidDocBlockArchitecturalDecision::class);
        $this->expectExceptionMessage(
            'Architectural Decision Records derived from a doc block MUST implement '
            . ArchitecturalDecisionRecord::class . ', but ' . self::class . ' does not'
        );

        DecisionContents::fromClassLevelDocBlock(self::class);
    }

    public function testDocBlockDecisionDoesNotHaveDocBlockThrowsException() : void {
        $this->expectException(InvalidDocBlockArchitecturalDecision::class);
        $this->expectExceptionMessage(
            'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
            . MissingDocBlockArchitecturalDecision::class . ' does not'
        );

        DecisionContents::fromClassLevelDocBlock(MissingDocBlockArchitecturalDecision::class);
    }

    public function testDocBlockPresentHasCorrectContents() : void {
        $contents = DecisionContents::fromClassLevelDocBlock(StubDocBlockArchitecturalDecision::class);

        $expected = <<<TEXT
        This is a DocBlock explaining an architectural decision.
        
        This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
        displayed in the CLI tool explaining the reason for the Architectural Decision.
        TEXT;

        self::assertSame($expected, $contents->value);
    }


}