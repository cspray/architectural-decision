<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\MissingDocBlock;
use DOMElement;

abstract class DocBlockArchitecturalDecision implements ArchitecturalDecisionRecord {

    private ?string $contents = null;

    public function getId() : string {
        $parts = explode('\\', static::class);
        return array_pop($parts);
    }

    final public function getContents() : string {
        if (!isset($this->contents)) {
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

            $this->contents = implode(PHP_EOL, $parts);
        }

        return $this->contents;
    }

    public function setMetaData(DOMElement $meta) : void {
        // noop, override to set your custom meta data
    }
}