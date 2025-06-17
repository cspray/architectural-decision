<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use DateTimeImmutable;
use Override;

abstract class DocBlockArchitecturalDecision implements ArchitecturalDecisionRecord {

    private readonly DecisionId $id;
    private readonly DecisionContents $contents;

    /**
     * @param non-empty-list<DecisionAuthor> $authors
     * @param list<DecisionMetaData> $metaData
     */
    protected function __construct(
        private readonly DateTimeImmutable $date,
        private readonly DecisionStatus $status,
        private readonly array $authors,
        private readonly array $metaData = [],
    ) {
        $this->id = DecisionId::fromUniqueString(static::class);
        $this->contents = DecisionContents::fromClassLevelDocBlock(static::class);
    }

    #[Override]
    final public function id() : DecisionId {
        return $this->id;
    }

    #[Override]
    final public function date() : DateTimeImmutable {
        return $this->date;
    }

    #[Override]
    final public function authors() : array {
        return $this->authors;
    }

    #[Override]
    final public function status() : DecisionStatus {
        return $this->status;
    }

    #[Override]
    final public function contents() : DecisionContents {
        return $this->contents;
    }

    #[Override]
    /**
     * @return list<DecisionMetaData>
     */
    final public function metaData() : array {
        return $this->metaData;
    }
}