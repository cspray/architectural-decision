<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\ArchitecturalDecision\Exception\DuplicateArchitecturalDecisionRecord;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * @api
 * @implements IteratorAggregate<int, ArchitecturalDecisionRecord>
 */
final readonly class ArchitecturalDecisionRecordCollection implements IteratorAggregate {

    /**
     * @param list<ArchitecturalDecisionRecord> $records
     */
    private function __construct(
        private array $records
    ) {
    }

    public static function empty() : self {
        return new self([]);
    }

    /**
     * @param non-empty-list<ArchitecturalDecisionRecord> $records
     * @throws DuplicateArchitecturalDecisionRecord
     */
    public static function fromList(array $records) : self {
        $clean = [];
        while ($records !== []) {
            $record = array_shift($records);
            $recordFound = array_any(
                $records,
                static fn(ArchitecturalDecisionRecord $r) => $r->id()->equals($record->id())
            );
            if ($recordFound) {
                throw DuplicateArchitecturalDecisionRecord::fromAdrWithDecisionIdAlreadyAddedToCollection($record);
            }

            $clean[] = $record;
        }

        return new self($clean);
    }

    #[Override]
    public function getIterator() : Traversable {
        yield from $this->records;
    }
}