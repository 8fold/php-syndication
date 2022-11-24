<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Json\Item;

class Items
implements Traversable, Iterator, Countable, JsonSerializable
{
    private int|string $position = 0;

    private array $collection;

    public static function create(Item ...$items): self
    {
        return new self(...$items);
    }

    final private function __construct(Item ...$items)
    {
        $this->collection = $items;
    }

    /**
     * @return array<int|string, object>
     */
    public function collection(): array
    {
        return $this->collection;
    }

    /*********** JsonSerializable ***********/
    public function jsonSerialize(): mixed
    {
        return $this->collection();
    }

    /*********** Countable ***********/
    public function count(): int
    {
        return count($this->collection());
    }

    /*********** Iterator ***********/
    public function current(): object
    {
        $a = $this->collection();
        return $a[$this->position];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function key(): int|string
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        $a = $this->collection();

        return isset($a[$this->position]);
    }
}
