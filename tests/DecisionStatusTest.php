<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\DataProvider\GenericStringProvider;
use Cspray\ArchitecturalDecision\Exception\EmptyDecisionStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecisionStatus::class)]
#[CoversClass(EmptyDecisionStatus::class)]
final class DecisionStatusTest extends TestCase {

    #[DataProviderExternal(GenericStringProvider::class, 'emptyStringProvider')]
    public function testEmptyStatusThrowsException(string $status) : void {
        $this->expectException(EmptyDecisionStatus::class);
        $this->expectExceptionMessage('An Architectural Decision Record status MUST be a non-empty string');

        DecisionStatus::fromCustomStatus($status);
    }

    public function testNonEmptyStatusReturnsCorrectValue() : void {
        $status = DecisionStatus::fromCustomStatus('Up');

        self::assertSame('Up', $status->value);
    }

    public function testWhenSameStatusEqualsIsTrue() : void {
        $status = DecisionStatus::fromCustomStatus('Trendsetter');

        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Trendsetter')));
    }

    public function testWhenNotSameStatusEqualsIsFalse() : void {
        $status = DecisionStatus::fromCustomStatus('Seesaw');

        self::assertFalse($status->equals(DecisionStatus::fromCustomStatus('Feline')));
    }

    public function testWhenUsingStandardAcceptedStatusCorrectValueAndEquals() : void {
        $status = DecisionStatus::accepted();

        self::assertSame('Accepted', $status->value);
        self::assertTrue($status->equals(DecisionStatus::accepted()));
        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Accepted')));
    }

    public function testWhenUsingStandardRejectedStatusCorrectValueAndEquals() : void {
        $status = DecisionStatus::rejected();

        self::assertSame('Rejected', $status->value);
        self::assertTrue($status->equals(DecisionStatus::rejected()));
        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Rejected')));
    }

    public function testWhenUsingStandardDraftStatusCorrectValueAndEquals() : void {
        $status = DecisionStatus::draft();

        self::assertSame('Draft', $status->value);
        self::assertTrue($status->equals(DecisionStatus::draft()));
        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Draft')));
    }

    public function testWhenUsingStandardWorkingDraftStatusCorrectValueAndEquals() : void {
        $status = DecisionStatus::workingDraft();

        self::assertSame('Draft - Working', $status->value);
        self::assertTrue($status->equals(DecisionStatus::workingDraft()));
        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Draft - Working')));
    }

    public function testWhenUsingStandardSupersededStatusCorrectValueAndEquals() : void {
        $status = DecisionStatus::superseded();

        self::assertSame('Superseded', $status->value);
        self::assertTrue($status->equals(DecisionStatus::superseded()));
        self::assertTrue($status->equals(DecisionStatus::fromCustomStatus('Superseded')));
    }

}