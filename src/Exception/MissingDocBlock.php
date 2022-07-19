<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Exception;

final class MissingDocBlock extends Exception {

    public static function fromClass(string $class) : self {
        return new self(sprintf('Expected to find a DocBlock associated with %s', $class));
    }

}