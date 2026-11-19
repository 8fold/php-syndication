<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Json\CustomObject;

/**
 * @implements Iterator<int, CustomObject>
 */
class CustomObjects implements Iterator, Countable, JsonSerializable
{
    /**
     * @var list<CustomObject>
     */
    private array $collection = [];

    private int $position = 0;

    public static function create(CustomObject ...$objects): self
    {
        return new self(...$objects);
    }

    final private function __construct(CustomObject ...$objects)
    {
        $this->collection = array_values($objects);
    }

    /**
     * JsonSerializable
     *
     * @return list<CustomObject>
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
