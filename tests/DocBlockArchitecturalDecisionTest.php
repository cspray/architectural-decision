<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubWithMetaDataArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DocBlockArchitecturalDecision::class)]
#[CoversClass(InvalidDocBlockArchitecturalDecision::class)]
#[UsesClass(DecisionId::class)]
#[UsesClass(DecisionStatus::class)]
#[UsesClass(DecisionContents::class)]
#[UsesClass(DecisionMetaData::class)]
#[UsesClass(DecisionMetaDataProperty::class)]
#[UsesClass(DecisionAuthor::class)]
final class DocBlockArchitecturalDecisionTest extends TestCase {

    public function testGetContentsReturnsDocBlock() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        $expected = <<<DOC
        This is a DocBlock explaining an architectural decision.

        This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
        displayed in the CLI tool explaining the reason for the Architectural Decision.
        DOC;

        self::assertSame($expected, $subject->contents()->value);
    }

    public function testGetTitleReturnsConstructorArgument() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        self::assertSame(StubDocBlockArchitecturalDecision::class, $subject->id()->value);
    }

    public function testGetStatusReturnsConstructorArgument() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        self::assertTrue($subject->status()->equals(DecisionStatus::accepted()));
    }

    public function testGetDateReturnsConstructorArgument() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        self::assertSame('2022-01-01', $subject->date()->format('Y-m-d'));
    }

    public function testGetMetaDataReturnsEmptyCollection() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        self::assertSame([], $subject->metaData());
    }

    public function testGetDecisionAuthorsReturnsCorrectRecords() : void {
        $subject = new StubWithMetaDataArchitecturalDecision();

        self::assertCount(1, $subject->authors());
        self::assertContainsOnlyInstancesOf(DecisionAuthor::class, $subject->authors());
        self::assertSame('Charles Sprayberry', $subject->authors()[0]->name);
    }

    public function testGetContentsMissingDocBlockThrowsException() : void {
        self::expectException(InvalidDocBlockArchitecturalDecision::class);
        self::expectExceptionMessage(
            'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
            . MissingDocBlockArchitecturalDecision::class . ' does not'
        );

        new MissingDocBlockArchitecturalDecision();
    }

    public function testDecisionWithMetaDataHasCorrectData() : void {
        $subject = new StubWithMetaDataArchitecturalDecision();

        $metaData = $subject->metaData();
        self::assertCount(2, $metaData);

        self::assertSame('foo', $metaData[0]->key);
        self::assertSame('bar', $metaData[0]->value);
        self::assertSame([], $metaData[0]->properties);

        self::assertSame('with-properties', $metaData[1]->key);
        self::assertSame(42, $metaData[1]->value);
        self::assertCount(2, $metaData[1]->properties);
        self::assertSame('prop-one', $metaData[1]->properties[0]->key);
        self::assertSame('prop-one-value', $metaData[1]->properties[0]->value);
        self::assertSame('prop-two', $metaData[1]->properties[1]->key);
        self::assertSame('prop-two-value', $metaData[1]->properties[1]->value);
    }

}