<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Stub\Adr\AnotherDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use PHPUnit\Framework\TestCase;
use function Cspray\Typiphy\objectType;

/**
 * @covers \Cspray\ArchitecturalDecision\SourceArchitecturalDecisionAttributeRegistry
 */
final class SourceArchitecturalDecisionAttributeRegistryTest extends TestCase {

    public function testSourceDirectoryContainsAttributes() : void {
        $subject = new SourceArchitecturalDecisionAttributeRegistry([__DIR__]);

        $attributes = $subject->getArchitecturalDecisionAttributes();

        self::assertCount(3, $attributes);
        self::assertSame([
            objectType(MissingDocBlockArchitecturalDecision::class),
            objectType(StubDocBlockArchitecturalDecision::class),
            objectType(AnotherDocBlockArchitecturalDecision::class),
        ], $attributes);
    }

}