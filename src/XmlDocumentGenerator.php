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
            /** @psalm-var class-string $type */
            $type = $attributeType->getName();
            $decisionAnnotations[$type] = [
                'attribute' => (new ReflectionClass($type))->newInstance(),
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
            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'architecturalDecisions')
        );

        foreach ($decisionAnnotations as $decisionAnnotation) {
            /** @var ArchitecturalDecisionRecord $attribute */
            $attribute = $decisionAnnotation['attribute'];

            $decisionsNode->appendChild(
                $decisionElement = $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'architecturalDecision')
            );

            $decisionElement->setAttribute('id', $attribute->getId());
            $decisionElement->setAttribute('attribute', $attribute::class);

            $decisionElement->appendChild(
                $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'date', $attribute->getDate())
            );

            $status = $attribute->getStatus();
            if ($status instanceof DecisionStatus) {
                $status = $status->value;
            }
            $decisionElement->appendChild(
                $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'status', $status)
            );

            $contentsNode = $decisionElement->appendChild(
                $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'contents')
            );

            $contentsNode->appendChild(
                $contentsNode->ownerDocument->createCDATASection($attribute->getContents())
            );

            if ($decisionAnnotation['targets'] !== []) {
                $codeAnnotationsNode = $decisionElement->appendChild(
                    $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'codeAnnotations')
                );

                foreach ($decisionAnnotation['targets'] as $target) {
                    $annotationNode = $codeAnnotationsNode->appendChild(
                        $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'codeAnnotation')
                    );

                    $targetReflection = $target->getTargetReflection();
                    if ($targetReflection instanceof ReflectionClass) {
                        $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'class', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionClassConstant) {
                        $classConstantNode = $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'classConstant')
                        );
                        $classConstantNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classConstantNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'constant', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionProperty) {
                        $classPropertyNode = $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'classProperty')
                        );
                        $classPropertyNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classPropertyNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'property', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionMethod) {
                        $classMethodNode = $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'classMethod')
                        );
                        $classMethodNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classMethodNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'method', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionParameter && $targetReflection->getDeclaringClass() !== null) {
                        $classMethodParameterNode = $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'classMethodParameter')
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'class', $targetReflection->getDeclaringClass()->getName())
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'method', $targetReflection->getDeclaringFunction()->getName())
                        );
                        $classMethodParameterNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'parameter', $targetReflection->getName())
                        );
                    } else if ($targetReflection instanceof ReflectionParameter) {
                        $functionParameterNode = $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'functionParameter')
                        );
                        $functionParameterNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'function', $targetReflection->getDeclaringFunction()->getName())
                        );
                        $functionParameterNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'parameter', $targetReflection->getName())
                        );
                    } else {
                        $annotationNode->appendChild(
                            $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'function', $targetReflection->getName())
                        );
                    }
                }
            }

            $decisionElement->appendChild(
                $meta = $dom->createElementNS(ArchitecturalDecisionRecord::SCHEMA, 'meta')
            );

            $attribute->setMetaData($meta);
        }

        $dom->schemaValidate(dirname(__DIR__) . '/architectural-decision.xsd');
        $dom->save($file);
    }
}