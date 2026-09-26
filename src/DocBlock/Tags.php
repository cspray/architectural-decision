<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * @implements IteratorAggregate<non-empty-string, string|list<string>>
 */
final readonly class Tags implements Countable, IteratorAggregate {

    /**
     * @param array<non-empty-string, string|list<string>> $tags
     */
    public function __construct(
        private array $tags,
    ) {}

    public function has(string $name): bool {
        return array_key_exists($name, $this->tags);
    }

    /**
     * @param string $name
     * @return string|list<string>|null
     */
    public function get(string $name): null|string|array {
        return $this->tags[$name] ?? null;
    }

    #[Override]
    public function getIterator() : Traversable {
        yield from $this->tags;
    }

    #[Override]
    public function count() : int {
        return count($this->tags);
    }
}