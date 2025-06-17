# Architectural Decision

[![Unit Tests & Static Analysis](https://github.com/cspray/architectural-decision/actions/workflows/testing.yml/badge.svg)](https://github.com/cspray/architectural-decision/actions/workflows/testing.yml)

An [Architectural Decision](https://en.wikipedia.org/wiki/Architectural_decision) is a design decision that could potentially have a large impact on your codebase. Why those decisions were made, from a technical perspective and a business perspective, are important, so they should be documented properly. This library allows you to document Architectural Decision Records (ADR) as an Attribute within your codebase. Doing so provides some functionality that might be useful:

- Architectural Decisions are close to your codebase. As in, the decision is right there in the repo, and you don't have to hunt through another system to find it.
- Architectural Decisions are _code_ in your codebase. As an Attribute you can mark the places in your code that are impacted by this decision. This makes it easier for existing maintainers and new developers to realize there's relevant information. If you implement the ADR following the conventions of this library PHPStorm and other IDEs will show you that decision simply by hovering over the Attribute.
- Statically analyze the impact of your decision. Over time as more of your codebase becomes annotated with Attributes you may be able to glean more information about the decision.

## Installation

```shell
composer require cspray/architectural-decision
```

## Usage Guide

The first thing to do is implement an Architectural Decision Record! This is handled with the `Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord` interface. I recommend you use the abstract `Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision` class. This implementation will use the DocBlock for the Attribute as the contents of the decision.

```php
<?php declare(strict_types=1);

namespace Acme\ArchitecturalDecisions;

use Cspray\ArchitecturalDecision\DecisionAuthor;use Cspray\ArchitecturalDecision\DecisionMetaData;use Cspray\ArchitecturalDecision\DecisionStatus;use Cspray\ArchitecturalDecision\SupportedDecisionStatus;
use Cspray\ArchitecturalDecision\DocBlockArchitecturalDecision;
use Attribute;
use DateTimeImmutable;

/**
 * Explain the decision and its potential business impact. 
 */
#[Attribute]
final class MyFirstDecision extends DocBlockArchitecturalDecision {

    public function __construct() {
        parent::__construct(
            date: new DateTimeImmutable('2022-07-19'),
            status: DecisionStatus::draft(),
            authors: [DecisionAuthor::fromName('cspray')],
            metaData: [
                DecisionMetaData::keyValue('since', 'v1.3')
            ]
        );
    }

}
```

Optionally, you can also annotate appropriate places in your codebase where it might make sense to do so.
