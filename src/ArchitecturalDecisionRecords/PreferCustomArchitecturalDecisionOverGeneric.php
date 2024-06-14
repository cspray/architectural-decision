<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\ArchitecturalDecisionRecords;

use Attribute;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use DateTimeImmutable;

/**
 * # Prefer Custom ArchitecturalDecisionRecord Over Generic
 *
 * It is preferred to create a custom Attribute per decision over implementing a generic Attribute to handle many
 * decisions.
 *
 * ## Problem Description
 *
 * As a developer using Architectural Decision I would like to use a generic Attribute to define an Architectural Decision
 * Record instead of having to implement a custom Attribute unique to each decision.
 *
 * ## Decision
 *
 * One of the earliest decisions in the design of this library was to have the supported use case be a custom Attribute
 * per ADR and to discourage the use of a generic attribute, e.g. #[ADR('Title', '2022-07-19', 'Reasoning')]. On the
 * surface a generic Attribute has some advantages, there are also drawbacks that make them a poor solution for what
 * this library is trying to accomplish. Specifically, I identify 3 problems with the generic Attribute approach.
 *
 * 1. Generic Attributes increase the likelihood that you'll have to repeat information and that errors/typos are
 * introduced. If you use a generic Attribute then every place that you use that Attribute in your codebase must also
 * include all the relevant information. This could easily turn problematic if the same ADR has different state in each
 * place it is attributed. The decision details should be documented in one, canonical place and not spread across your
 * codebase.
 *
 * 2. Generic Attributes do not facilitate static analysis. Having an explicit type for each decision allows for static
 * analysis tools to more easily infer information about each use of the Attribute. A generic Attribute for all decisions
 * would lose the ability to infer this information as you're now much more dependent on the value of the Attribute
 * instead of the type to infer which decision it refers to.
 *
 * 3. This library cannot rely strictly on Reflection to retrieve an Attribute instance and must be able to construct
 * an Attribute type without it being used in the codebase. To understand this restriction let's look at how you would
 * typically get an instance of an Attribute that's been annotated on a class. Given the following code example:
 *
 * <code>
 * #[Attribute]
 * class SomeAttribute {
 *
 *      public function __construct(
 *          public readonly string $foo,
 *          public readonly string $bar
 *      ) {}
 *
 * }
 *
 * #[SomeAttribute('baz', 'qux')]
 * class SomeClass {
 *
 * }
 * </code>
 *
 *
 * To retrieve the instance of SomeAttribute that has 'baz' and 'qux' stored in the attribute's state we'd have to run
 * code that resembles the following:
 *
 * <code>
 * $reflection = new ReflectionClass(SomeClass::class);
 * $reflectionAttribute = $reflection->getAttributes(SomeAttribute::class)[0];
 * $instance = $reflectionAttribute->newInstance();
 *
 * echo $instance->foo; // baz
 * echo $instance->bar; // qux
 * </code>
 *
 * For traditional Attribute usage this is perfectly sufficient. However, since this library is using the Attribute in a
 * non-traditional sense we can't always rely on being able to execute this code. For example, if you write an ADR as an
 * Attribute but then never annotate anything in your codebase with it. In this scenario your ADR would not be included.
 * Not including an ADR because it hasn't been used in your codebase is considered a bug. To prevent this from happening
 * we must be able to construct a Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord instance without using the
 * Reflection API.
 *
 * It is possible to resolve this problem by allowing a factory construct the ArchitecturalDecisionRecord instances, but
 * with additional complexity and not solving either of the 2 primary problems with generic Attributes. Instead of doing
 * that it is encouraged to always implement a custom Attribute per decision. If you have a compelling use case that can
 * only be solved by having control of the Attribute instance is created please submit an Issue at
 * https://github.com/cspray/architectural-decision.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class PreferCustomArchitecturalDecisionOverGeneric extends DocBlockArchitecturalDecision {

    public function date() : DateTimeImmutable {
        return new DateTimeImmutable('2022-07-19', new \DateTimeZone('America/New_York'));
    }

    public function status() : DecisionStatus {
        return DecisionStatus::Accepted;
    }
}