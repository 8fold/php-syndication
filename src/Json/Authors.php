<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Json\Author;

/**
 * @implements Iterator<int, Author>
 */
class Authors implements Iterator, Countable, JsonSerializable
{
    /**
     * @var list<Author>
     */
    private array $collection = [];

    private int $position = 0;

    public static function create(Author ...$authors): self
    {
        return new self(...$authors);
    }

    final private function __construct(Author ...$authors)
    {
        $this->collection = array_values($authors);
    }

    /**
     * JsonSerializable
     *
     * @return list<Author>
     **/
    public function jsonSerialize(): array
    {
        return $this->collection;
    }

    /** Countable **/
    public function count(): int
    {
        return count($this->collection);
    }

    /** Iterator **/
    public function current(): object
    {
        return $this->collection[$this->position];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }
}
