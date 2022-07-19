<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets;

use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;

#[StubDocBlockArchitecturalDecision]
final class KitchenSink {

    #[StubDocBlockArchitecturalDecision]
    private const MY_CONST = 'foo';

    #[StubDocBlockArchitecturalDecision]
    private $someProp;

    #[StubDocBlockArchitecturalDecision]
    public function myMethod() : void {

    }

    private function myPrivateMethod(
        #[StubDocBlockArchitecturalDecision]
        string $param
    ) : void {}

}

#[StubDocBlockArchitecturalDecision]
function myFunction() : void {

}

function anotherFunction(
    #[StubDocBlockArchitecturalDecision]
    int $flag
) : void {}