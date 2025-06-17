<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

final readonly class DecisionMetaDataProperty {

    /**
     * @param non-empty-string $key
     * @param non-empty-string $value
     */
    private function __construct(
        public string $key,
        public string $value
    ) {}

    /**
     * @param non-empty-string $key
     * @param non-empty-string $value
     */
    public static function keyValue(string $key, string $value) : self {
        return new self($key, $value);
    }

}