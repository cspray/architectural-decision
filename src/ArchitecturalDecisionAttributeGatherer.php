<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\AnnotatedTarget\AnnotatedTargetParser;
use Cspray\AnnotatedTarget\AnnotatedTargetParserOptionsBuilder;
use Cspray\ArchitecturalDecision\Exception\AttributeNotArchitecturalDecisionRecord;
use Cspray\Typiphy\ObjectType;
use Generator;
use function Cspray\Typiphy\objectType;

final class ArchitecturalDecisionAttributeGatherer {

    /** @var list<ObjectType> $attributeTypes */
    private array $attributeTypes = [];

    public function __construct(private readonly AnnotatedTargetParser $annotatedTargetParser) {

    }

    /**
     * @return list<ObjectType>
     */
    public function registeredAttributes() : array {
        return $this->attributeTypes;
    }

    /**
     * @param class-string $attributeType
     */
    public function registerAttribute(string $attributeType) : void {
        if (!is_subclass_of($attributeType, ArchitecturalDecisionRecord::class)) {
            throw AttributeNotArchitecturalDecisionRecord::invalidAttributeType($attributeType);
        }

        $this->attributeTypes[] = objectType($attributeType);
    }

    /**
     * @param list<string> $dirs
     * @throws \Cspray\AnnotatedTarget\Exception\InvalidArgumentException
     */
    public function gatherArchitecturalDecisionAttributes(array $dirs) : Generator {
        return $this->annotatedTargetParser->parse(
            AnnotatedTargetParserOptionsBuilder::scanDirectories(...$dirs)
                ->filterAttributes(...$this->attributeTypes)
                ->build()
        );
    }

}