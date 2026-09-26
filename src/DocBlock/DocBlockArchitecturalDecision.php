<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use Cspray\ArchitecturalDecision\ArchitecturalDecisionRecord;
use Cspray\ArchitecturalDecision\DecisionAuthor;
use Cspray\ArchitecturalDecision\DecisionContents;
use Cspray\ArchitecturalDecision\DecisionId;
use Cspray\ArchitecturalDecision\DecisionMetaData;
use Cspray\ArchitecturalDecision\DecisionStatus;
use Cspray\ArchitecturalDecision\Exception\InvalidDocBlockArchitecturalDecision;
use DateMalformedStringException;
use DateTimeImmutable;
use Override;
use ReflectionClass;
use Webmozart\Assert\Assert;

abstract class DocBlockArchitecturalDecision implements ArchitecturalDecisionRecord {

    private readonly DecisionId $id;
    private readonly DecisionContents $contents;
    private readonly DateTimeImmutable $date;
    private readonly DecisionStatus $status;
    /** @var non-empty-list<DecisionAuthor> */
    private readonly array $authors;
    /** @var list<DecisionMetaData> */
    private readonly array $metaData;

    public function __construct() {
        $classDocBlock = ClassDocBlock::fromReflection(new ReflectionClass(static::class));
        $validData = $this->validateClassDocBlock($classDocBlock);

        $this->id = DecisionId::fromUniqueString(static::class);
        $this->contents = DecisionContents::fromClassLevelDocBlock($classDocBlock);
        $this->date = new DateTimeImmutable($validData['date']);
        $this->status = DecisionStatus::fromCustomStatus($validData['status']);
        $this->authors = array_map(static fn(string $name) => DecisionAuthor::fromName($name), $validData['author']) ;
        $this->metaData = $this->metaDataFromClassDocBlock($classDocBlock);
    }

    /**
     * @param ClassDocBlock $classDocBlock
     * @return array{date: non-empty-string, status: non-empty-string, author: non-empty-list<non-empty-string>}
     * @throws InvalidDocBlockArchitecturalDecision
     */
    private function validateClassDocBlock(ClassDocBlock $classDocBlock) : array
    {
        if ($classDocBlock->contents === null) {
            throw InvalidDocBlockArchitecturalDecision::fromArchitecturalDecisionRecordHasNoDocBlock(
                $classDocBlock->class
            );
        }

        $validationFailures = [];

        $date = $classDocBlock->tags->get('date');
        if ($date === null || $date === '' || is_array($date) || $this->isDateInvalidDateTimeString($date)) {
            $validationFailures[] = 'A single @date tag with a valid date string MUST be provided';
        }
        /** @var non-empty-string $date */

        $status = $classDocBlock->tags->get('status');
        if ($status === null || $status === '' || is_array($status)) {
            $validationFailures[] = 'A single @status tag with a non-empty string MUST be provided';
        }
        /** @var non-empty-string $status */

        $author = $classDocBlock->tags->get('author');
        if ($author === null || $this->doesAuthorsIncludeBlankString($author)) {
            $validationFailures[] = 'One or more @author tags with a non-empty string MUST be provided';
        }
        /** @var non-empty-list<non-empty-string>|non-empty-string $author */

        if ($validationFailures !== []) {
            throw InvalidDocBlockArchitecturalDecision::fromArchitecturalDecisionRecordDoesNotHaveRequiredTags(
                $classDocBlock->class,
                $validationFailures,
            );
        }

        return [
            'date' => $date,
            'status' => $status,
            'author' => is_string($author) ? [$author] : $author,
        ];
    }

    private function isDateInvalidDateTimeString(string $date) : bool {
        try {
            new DateTimeImmutable($date);
            return false;
        } catch (DateMalformedStringException) {
            return true;
        }
    }

    private function doesAuthorsIncludeBlankString(array|string $authors) : bool {
        $authors = is_string($authors) ? [$authors] : $authors;
        if (array_filter($authors, static fn(string $author) => $author === '') !== []) {
            return true;
        }

        return false;
    }

    /**
     * @return list<DecisionMetaData>
     */
    private function metaDataFromClassDocBlock(ClassDocBlock $classDocBlock) : array
    {
        $metaAnnotations = array_filter(
            iterator_to_array($classDocBlock->tags),
            static fn(string|int $key) : bool => ! in_array($key, ['author', 'date', 'status'], true),
            ARRAY_FILTER_USE_KEY,
        );

        $metaData = [];
        foreach ($metaAnnotations as $key => $value) {
            $metaData[] = DecisionMetaData::keyValue($key, $value);
        }

        return $metaData;
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