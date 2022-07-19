<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\MissingDocBlock;

abstract class DocBlockArchitecturalDecision implements ArchitecturalDecisionRecord {

    public function getContents() : string {
        $reflection = new \ReflectionClass(static::class);
        $content = $reflection->getDocComment();

        if (!$content) {
            throw MissingDocBlock::fromClass($reflection->getName());
        }

        $parts = explode(PHP_EOL, $content);
        array_shift($parts);
        array_pop($parts);

        foreach ($parts as $index => $part) {
            $parts[$index] = ltrim($part, ' *');
        }

        return implode(PHP_EOL, $parts);
    }
}