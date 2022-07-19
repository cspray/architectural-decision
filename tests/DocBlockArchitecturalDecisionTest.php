<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\MissingDocBlock;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision
 */
final class DocBlockArchitecturalDecisionTest extends TestCase {

    public function testGetContentsReturnsDocBlock() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        $expected = <<<DOC
This is a DocBlock explaining an architectural decision.

This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
displayed in the CLI tool explaining the reason for the Architectural Decision.
DOC;

        self::assertSame($expected, $subject->getContents());
    }

    public function testGetTitleReturnsConstructorArgument() : void {
        $subject = new StubDocBlockArchitecturalDecision();

        self::assertSame('Stub Title', $subject->getTitle());
    }

    public function testGetContentsMissingDocBlockThrowsException() : void {
        $subject = new MissingDocBlockArchitecturalDecision();

        self::expectException(MissingDocBlock::class);
        self::expectExceptionMessage('Expected to find a DocBlock associated with ' . MissingDocBlockArchitecturalDecision::class);

        $subject->getContents();
    }

}