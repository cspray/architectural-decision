<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

final readonly class DecisionMetaData {

    /**
     * @param non-empty-string $key
     * @param non-empty-string|int|float|bool $value
     * @param list<DecisionMetaDataProperty> $properties
     */
    private function __construct(
        public string $key,
        public string|int|float|bool $value,
        public array $properties
    ) {}

    /**
     * @param non-empty-string $key
     * @param non-empty-string|int|float|bool $value
     */
    public static function keyValue(string $key, string|int|float|bool $value) : self {
        return new self($key, $value, []);
    }

    /**
     * @param non-empty-string $key
     * @param non-empty-string|int|float|bool $value
     * @param non-empty-list<DecisionMetaDataProperty> $properties
     */
    public static function keyValueWithProperties(string $key, string|int|float|bool $value, array $properties) : self {
        return new self($key, $value, $properties);
    }
}