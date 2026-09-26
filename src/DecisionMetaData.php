<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

final readonly class DecisionMetaData {

    /**
     * @param non-empty-string $key
     * @param string|list<string> $value
     */
    private function __construct(
        public string $key,
        public string|array $value,
    ) {}

    /**
     * @param non-empty-string $key
     * @param string|list<string> $value
     */
    public static function keyValue(string $key, string|array $value) : self {
        return new self($key, $value);
    }
}