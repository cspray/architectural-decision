<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\AnnotatedTarget\AnnotatedTarget;
use DOMDocument;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;

final class XmlDocumentGenerator {

    private const SCHEMA = 'https://architectural-decision.cspray.io/schema/architectural-decision.xsd';

    public function __construct(
        private readonly ArchitecturalDecisionAttributeGatherer $gatherer
    ) {}

    /**
     * @param list<string> $scanDirs
     * @throws \Cspray\AnnotatedTarget\Exception\InvalidArgumentException
     * @throws \DOMException
     */
    public function generateDocument(string $file, array $scanDirs) : void {
        /** @var array<class-string, array{attribute: ArchitecturalDecisionRecord, targets: list<AnnotatedTarget>}> $decisionAnnotations */
        $decisionAnnotations = [];

        foreach ($this->gatherer->getRegisteredAttributes() as $attributeType) {
            $type = $attributeType->getName();
            $decisionAnnotations[$type] = [
                'attribute' => new $type(),
                'targets' => []
            ];
        }

        /** @var AnnotatedTarget $annotatedTarget */
        foreach ($this->gatherer->gatherArchitecturalDecisionAttributes($scanDirs) as $annotatedTarget) {
            $attributeType = $annotatedTarget->getAttributeReflection()->getName();
            $decisionAnnotations[$attributeType]['targets'][] = $annotatedTarget;
        }

        $dom = new DOMDocument(encoding: 'UTF-8');
        $dom->formatOutput = true;

        $decisionsNode = $dom->appendChild(
            $dom->createElementNS(self::SCHEMA, 'architecturalDecisions')
        );

        foreach ($decisionAnnotations as $decisionAnnotation) {
            /** @var ArchitecturalDecisionRecord $attribute */
            $attribute = $decisionAnnotation['attribute'];

            $decisionNode = $decisionsNode->appendChild(
                $dom->createElementNS(self::SCHEMA, 'architecturalDecision')
            );

            $decisionNode->appendChild(
                $dom->createElementNS(self::SCHEMA, 'attribute', $attribute::class)
            );

            $decisionNode->appendChild(
                $dom->createElementNS(self::SCHEMA, 'title', $attribute->getTitle())
            );

            $decisionNode->appendChild(
                $dom->createElementNS(self::SCHEMA, 'date', $attribute->getDate())
            );

            $contentsNode = $decisionNode->appendChild(
                $dom->createElementNS(self::SCHEMA, 'contents')
            );

            assert(!is_null($contentsNode->ownerDocument));
            $contentsNode->appendChild(
                $contentsNode->ownerDocument->createCDATASection($attribute->getContents())
            );

            if (!empty($decisionAnnotation['targets'])) {
                $codeAnnotationsNode = $decisionNode->appendChild(
                    $dom->createElementNS(self::SCHEMA, 'codeAnnotations')
                );

                foreach ($decisionAnnotation['targets'] as $target) {
                    $annotationNode = $codeAnnotationsNode->appendChild(
                        $dom->createElementNS(self::SCHEMA, 'codeAnnotation')
                    );

                    $targetReflection = $target->getTargetReflection();
                    if ($targetReflection instanceof ReflectionClass) {
                        $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'class', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionClassConstant) {
                        $classConstantNode = $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'classConstant')
                        );
                        $classConstantNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classConstantNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'constant', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionProperty) {
                        $classPropertyNode = $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'classProperty')
                        );
                        $classPropertyNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classPropertyNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'property', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionMethod) {
                        $classMethodNode = $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'classMethod')
                        );
                        $classMethodNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classMethodNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'method', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionParameter && $targetReflection->getDeclaringClass() !== null) {
                        $classMethodParameterNode = $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'classMethodParameter')
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'method', $targetReflection->getDeclaringFunction()->getName())
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'parameter', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionParameter) {
                        $functionParameterNode = $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'functionParameter')
                        );
                        $functionParameterNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'function', $targetReflection->getDeclaringFunction()->getName())
                        );
                        $functionParameterNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'parameter', $targetReflection->getName())
                        );
                    } else {
                        $annotationNode->appendChild(
                            $dom->createElementNS(self::SCHEMA, 'function', $targetReflection->getName())
                        );
                    }
                }
            }
        }

        $dom->schemaValidate(dirname(__DIR__) . '/architectural-decision.xsd');
        $dom->save($file);
    }
}