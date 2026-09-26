<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

final readonly class ClassDocBlock
{
    private function __construct(
        public string $class,
        public string|null $contents,
        public Tags $tags,
    ) {}

    public static function fromReflection(ReflectionClass $class): self
    {
        if ($class->getDocComment() === false) {
            return new self($class->name, null, new Tags([]));
        }

        $docBlock = DocBlockFactory::createInstance()->create($class);

        return new self($class->name, self::contentsFromDocBlock($docBlock), self::tagsFromDocBlock($docBlock));
    }

    private static function contentsFromDocBlock(DocBlock $docBlock) : string {
        return $docBlock->getSummary() . PHP_EOL . PHP_EOL . $docBlock->getDescription()->render();
    }

    private static function tagsFromDocBlock(DocBlock $docBlock) : Tags {
        $tags = [];
        foreach ($docBlock->getTags() as $tag) {
            $name = $tag->getName();
            assert($name !== '');
            if (! array_key_exists($name, $tags)) {
                $tags[$name] = (string) $tag;
            } else {
                if (is_array($tags[$name])) {
                    $tags[$name][] = (string) $tag;
                } else {
                    $tags[$name] = [$tags[$name], (string) $tag];
                }
            }
        }

        return new Tags($tags);
    }
}
