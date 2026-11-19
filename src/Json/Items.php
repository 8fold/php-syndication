<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Json\Item;

/**
 * @implements Iterator<int, Item>
 */
class Items implements Iterator, Countable, JsonSerializable
{
    /**
     * @var list<Item>
     */
    private array $collection = [];

    private int $position = 0;

    public static function create(Item ...$items): self
    {
        return new self(...$items);
    }

    final private function __construct(Item ...$items)
    {
        $this->collection = array_values($items);
    }

    /**
     * JsonSerializable
     *
     * @return list<Item>
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
