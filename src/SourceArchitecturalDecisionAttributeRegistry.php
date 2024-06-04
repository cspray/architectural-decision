<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\Typiphy\ObjectType;
use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use SplFileInfo;
use function Cspray\Typiphy\objectType;

final class SourceArchitecturalDecisionAttributeRegistry implements ArchitecturalDecisionAttributeRegistry {

    private readonly Parser $parser;

    /**
     * @param list<string> $searchDir
     */
    public function __construct(
        private readonly array $searchDir
    ) {
        $this->parser = (new ParserFactory())->createForNewestSupportedVersion();
    }

    public function getArchitecturalDecisionAttributes() : array {
        $gatherer = new class extends NodeVisitorAbstract {

            /**
             * @var list<ObjectType>
             */
            private array $types = [];

            /**
             * @return list<ObjectType>
             */
            public function getGatheredTypes() : array {
                return $this->types;
            }

            public function leaveNode(Node $node) {
                if (!$node instanceof Node\Stmt\Class_) {
                    return null;
                }

                if (isset($node->namespacedName) && !$node->isAbstract() && is_subclass_of($node->namespacedName->toString(), ArchitecturalDecisionRecord::class)) {
                    $this->types[] = objectType($node->namespacedName->toString());
                }
            }

        };

        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new NameResolver());
        $nodeTraverser->addVisitor($gatherer);

        foreach ($this->searchDir as $searchDir) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($searchDir));

            /** @var SplFileInfo $file */
            foreach ($iterator as $file) {
                if ($file->isDir() || $file->getExtension() !== 'php') {
                    continue;
                }

                $statements = $this->parser->parse(file_get_contents($file->getPathname()));

                assert(is_array($statements));
                $nodeTraverser->traverse($statements);
                unset($statements);
            }
        }

        return $gatherer->getGatheredTypes();
    }
}