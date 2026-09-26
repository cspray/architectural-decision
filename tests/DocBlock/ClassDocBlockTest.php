<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubWithMultipleAuthorDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClassDocBlock::class)]
#[UsesClass(Tags::class)]
final class ClassDocBlockTest extends TestCase
{
    public function testDocBlockClassWithAnnotationsHasCorrectData(): void
    {
        $reflection = new \ReflectionClass(StubDocBlockArchitecturalDecision::class);
        $docBlock = ClassDocBlock::fromReflection($reflection);

        $expectedContents = <<<TEXT
        This is a DocBlock explaining an architectural decision.
        
        This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
        displayed in the CLI tool explaining the reason for the Architectural Decision.
        TEXT;

        self::assertSame(StubDocBlockArchitecturalDecision::class, $docBlock->class);
        self::assertSame($expectedContents, $docBlock->contents);
        self::assertSame('2022-01-01', $docBlock->tags->get('date'));
        self::assertSame('Accepted', $docBlock->tags->get('status'));
        self::assertSame('Charles Sprayberry', $docBlock->tags->get('author'));
    }

    public function testDocBlockClassWithNoDocBlockHasNullContentsAndEmptyAnnotations(): void
    {
        $reflection = new \ReflectionClass(MissingDocBlockArchitecturalDecision::class);
        $docBlock = ClassDocBlock::fromReflection($reflection);

        self::assertSame(MissingDocBlockArchitecturalDecision::class, $docBlock->class);
        self::assertNull($docBlock->contents);
        // we expect any value to be null, but we can't realistically check that
        self::assertNull($docBlock->tags->get('author'));
    }

    public function testDocBlockClassWithMultipleAuthors(): void
    {
        $reflection = new \ReflectionClass(StubWithMultipleAuthorDocBlockArchitecturalDecision::class);
        $docBlock = ClassDocBlock::fromReflection($reflection);

        self::assertSame(StubWithMultipleAuthorDocBlockArchitecturalDecision::class, $docBlock->class);
        self::assertNotNull($docBlock->contents);
        self::assertSame(['Mack', 'Ellie', 'Nick', 'Kate'], $docBlock->tags->get('author'));
    }

}