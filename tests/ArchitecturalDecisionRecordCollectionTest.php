<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\DuplicateArchitecturalDecisionRecord;
use Cspray\ArchitecturalDecision\Exception\Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArchitecturalDecisionRecordCollection::class)]
#[CoversClass(DuplicateArchitecturalDecisionRecord::class)]
#[UsesClass(DecisionId::class)]
#[UsesClass(Exception::class)]
final class ArchitecturalDecisionRecordCollectionTest extends TestCase {

    public function testIterateOverEmptyCollectionResultsInEmptyArray() : void {
        $subject = ArchitecturalDecisionRecordCollection::empty();

        self::assertSame([], iterator_to_array($subject));
    }

    public function testFromListWithDuplicateArchitecturalDecisionRecordIdsThrowsException() : void {
        $a = $this->createMock(ArchitecturalDecisionRecord::class);
        $a->method('id')->willReturn(DecisionId::fromUniqueString('not unique'));

        $b = $this->createMock(ArchitecturalDecisionRecord::class);
        $b->method('id')->willReturn(DecisionId::fromUniqueString('not unique'));

        $this->expectException(DuplicateArchitecturalDecisionRecord::class);
        $this->expectExceptionMessage(
            'An Architectural Decision Record MUST have a unique ID, but multiple records were found with id "not unique"'
        );

        ArchitecturalDecisionRecordCollection::fromList([$a, $b]);
    }

    public function testIterateOverFromListWithNoDuplicatesResultsInCorrectCollection() : void {
        $a = $this->createMock(ArchitecturalDecisionRecord::class);
        $a->method('id')->willReturn(DecisionId::fromUniqueString('a'));

        $b = $this->createMock(ArchitecturalDecisionRecord::class);
        $b->method('id')->willReturn(DecisionId::fromUniqueString('b'));

        $subject = ArchitecturalDecisionRecordCollection::fromList([$a, $b]);

        self::assertSame([$a, $b], iterator_to_array($subject));
    }

}