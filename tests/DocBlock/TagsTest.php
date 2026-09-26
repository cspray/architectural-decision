<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision\DocBlock;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tags::class)]
final class TagsTest extends TestCase {

    public function testEmptyTagsHasCountOfZero() : void {
        $tags = new Tags([]);

        self::assertCount(0, $tags);
    }

    public function testEmptyTagsIteratesAnEmptyArray() : void {
        $tags = new Tags([]);

        self::assertSame([], iterator_to_array($tags));
    }

    public function testHasWithEmptyTagsReturnsFalse() : void {
        $tags = new Tags([]);

        self::assertFalse($tags->has('anything'));
    }

    public function testGetWithEmptyTagsReturnsNull() : void {
        $tags = new Tags([]);

        self::assertNull($tags->get('anything'));
    }

    public function testCountWithPopulatedTagsReturnsNumberOfElements() : void {
        $tags = new Tags([
            'date' => '2022-01-01',
            'author' => 'Harry Mack',
            'status' => 'Draft',
        ]);

        self::assertCount(3, $tags);
    }

    public function testIterateWithPopulatedTagsReturnsCorrectIterator() : void {
        $tags = new Tags([
            'date' => '2022-01-01',
            'author' => 'Harry Mack',
            'status' => 'Draft',
        ]);

        self::assertSame(
            ['date' => '2022-01-01', 'author' => 'Harry Mack', 'status' => 'Draft'],
            iterator_to_array($tags),
        );
    }

    public function testHasWithKeyPresentReturnsTrue() : void {
        $tags = new Tags(['date' => '2022-01-01']);

        self::assertTrue($tags->has('date'));
    }

    public function testGetWithKeyPresentReturnsValue() : void {
        $tags = new Tags([
            'author' => ['Harry Mack', 'Conor Price'],
            'status' => 'Draft',
        ]);

        self::assertSame('Draft', $tags->get('status'));
        self::assertSame(['Harry Mack', 'Conor Price'], $tags->get('author'));
    }

}