<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Stub\Adr\AnotherDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\Adr\StubMetaDataArchitecturalDecision;
use Cspray\ArchitecturalDecision\Stub\BadAdr\MissingDocBlockArchitecturalDecision;
use Cspray\Typiphy\ObjectType;
use PHPUnit\Framework\TestCase;
use function Cspray\Typiphy\objectType;

/**
 * @covers \Cspray\ArchitecturalDecision\SourceArchitecturalDecisionAttributeRegistry
 */
final class SourceArchitecturalDecisionAttributeRegistryTest extends TestCase {

    public function testSourceDirectoryContainsAttributes() : void {
        $subject = new SourceArchitecturalDecisionAttributeRegistry([__DIR__]);

        $attributes = $subject->architecturalDecisionAttributes();

        self::assertCount(4, $attributes);

        usort($attributes, fn(ObjectType $a, ObjectType $b) => $a->getName() <=> $b->getName());

        self::assertSame([
            objectType(AnotherDocBlockArchitecturalDecision::class),
            objectType(StubDocBlockArchitecturalDecision::class),
            objectType(StubMetaDataArchitecturalDecision::class),
            objectType(MissingDocBlockArchitecturalDecision::class),
        ], $attributes);
    }

}