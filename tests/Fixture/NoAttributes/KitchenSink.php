<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Fixture\NoAttributes;

final class KitchenSink {

    private const MY_CONST = 'foo';

    private $someProp;

    public function myMethod() : void {

    }

    private function myPrivateMethod(
        string $param
    ) : void {}

}

function myFunction() : void {

}

function anotherFunction(
    int $flag
) : void {}