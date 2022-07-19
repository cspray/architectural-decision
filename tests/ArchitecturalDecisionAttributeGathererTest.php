<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\AnnotatedTarget\PhpParserAnnotatedTargetParser;
use Cspray\ArchitecturalDecision\Exception\AttributeNotArchitecturalDecisionRecord;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Cspray\ArchitecturalDecision\ArchitecturalDecisionAttributeGatherer
 */
final class ArchitecturalDecisionAttributeGathererTest extends TestCase {

    private ArchitecturalDecisionAttributeGatherer $subject;

    protected function setUp() : void {
        parent::setUp();
        $this->subject = new ArchitecturalDecisionAttributeGatherer(
            new PhpParserAnnotatedTargetParser()
        );
    }

    public function testRegisterAttributeTypeThatIsNotCorrectInterfaceThrowsException() : void {
        self::expectException(AttributeNotArchitecturalDecisionRecord::class);
        self::expectExceptionMessage(
            'The Attribute ' . $this::class . ' MUST implement ' . ArchitecturalDecisionRecord::class
        );

        $this->subject->registerAttribute($this::class);
    }

    public function testRegisterAttributeTypeAndGatherUses() : void {
        $this->subject->registerAttribute(StubDocBlockArchitecturalDecision::class);

        $attributes = iterator_to_array($this->subject->gatherArchitecturalDecisionAttributes([
            __DIR__ . '/Fixture/AllAttributeTargets'
        ]));

        self::assertCount(7, $attributes);
    }

}