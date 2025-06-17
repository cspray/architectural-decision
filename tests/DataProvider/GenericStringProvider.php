<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DataProvider;

final class GenericStringProvider {

    private function __construct() {}

    public static function emptyStringProvider() : array {
        return [
            'empty-zero-length' => [''],
            'empty-blank-space' => [' '],
            'empty-tab' => ["\t"],
            'empty-new-line' => ["\n"],
        ];
    }

}