<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionContents;
use Cspray\ArchitecturalDecision\DecisionId;
use Cspray\ArchitecturalDecision\DecisionMetaData;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubWithMetaDataArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubWithMultipleAuthorDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\EmptyDateTagDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\EmptyMultipleAuthorTagDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\EmptySingleAuthorTagDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\EmptyStatusTagDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\InvalidDateStringDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingRequiredTagsDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MultipleDateTagDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MultipleStatusTagDocBlockArchitecturalDecision;
use Cspray\AssertThrows\ThrowableAssertTestCaseMethods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DocBlockArchitecturalDecision::class)]
#[CoversClass(InvalidDocBlockArchitecturalDecision::class)]
#[UsesClass(ClassDocBlock::class)]
#[UsesClass(Tags::class)]
#[UsesClass(DecisionId::class)]
#[UsesClass(DecisionStatus::class)]
#[UsesClass(DecisionContents::class)]
#[UsesClass(DecisionMetaData::class)]
#[UsesClass(DecisionAuthor::class)]
final class DocBlockArchitecturalDecisionTest extends TestCase {

    use ThrowableAssertTestCaseMethods;

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

    public function testDecisionWithMetaDataHasCorrectData() : void {
        $subject = new StubWithMetaDataArchitecturalDecision();

        $metaData = $subject->metaData();
        self::assertCount(3, $metaData);

        self::assertSame('foo', $metaData[0]->key);
        self::assertSame('bar', $metaData[0]->value);

        self::assertSame('propOne', $metaData[1]->key);
        self::assertSame('one prop value', $metaData[1]->value);
        self::assertSame('prop-two', $metaData[2]->key);
        self::assertSame('two prop value', $metaData[2]->value);
    }

    public function testDecisionWithMultipleAuthors() : void {
        $subject = new StubWithMultipleAuthorDocBlockArchitecturalDecision();

        $authors = $subject->authors();

        self::assertCount(4, $authors);
        self::assertContainsOnlyInstancesOf(DecisionAuthor::class, $authors);
        self::assertSame('Mack', $authors[0]->name);
        self::assertSame('Ellie', $authors[1]->name);
        self::assertSame('Nick', $authors[2]->name);
        self::assertSame('Kate', $authors[3]->name);
    }

    public function testGetContentsMissingDocBlockThrowsException() : void {
        $throwable = self::assertThrowsExceptionTypeWithMessage(
            static fn() => new MissingDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST have a class-level doc block, but '
            . MissingDocBlockArchitecturalDecision::class . ' does not'
        );

        self::assertSame([], $throwable->validationFailures);
    }

    public function testDocBlockArchitecturalDecisionRecordWithoutRequiredTagsThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new MissingRequiredTagsDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . MissingRequiredTagsDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            [
                'A single @date tag with a valid date string MUST be provided',
                'A single @status tag with a non-empty string MUST be provided',
                'One or more @author tags with a non-empty string MUST be provided',
            ],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithEmptyDateThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new EmptyDateTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . EmptyDateTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['A single @date tag with a valid date string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithMultipleDatesThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new MultipleDateTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . MultipleDateTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['A single @date tag with a valid date string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithInvalidDateStringThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new InvalidDateStringDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . InvalidDateStringDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['A single @date tag with a valid date string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithEmptyStatusThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new EmptyStatusTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . EmptyStatusTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['A single @status tag with a non-empty string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithMultipleStatusThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new MultipleStatusTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . MultipleStatusTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['A single @status tag with a non-empty string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithSingleBlankAuthorThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new EmptySingleAuthorTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . EmptySingleAuthorTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['One or more @author tags with a non-empty string MUST be provided'],
            $throwable->validationFailures,
        );
    }

    public function testDocBlockArchitecturalDecisionRecordWithMultipleAuthorsIncludeBlankThrowsException() : void {
        $throwable = $this->assertThrowsExceptionTypeWithMessage(
            static fn() => new EmptyMultipleAuthorTagDocBlockArchitecturalDecision(),
            InvalidDocBlockArchitecturalDecision::class,
            'Architectural Decision Records derived from a doc block MUST define all appropriate tags, but '
            . EmptyMultipleAuthorTagDocBlockArchitecturalDecision::class . ' does not',
        );

        self::assertSame(
            ['One or more @author tags with a non-empty string MUST be provided'],
            $throwable->validationFailures,
        );
    }

}