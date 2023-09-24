<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Json\CustomObject;

class CustomObjects implements Traversable, Iterator, Countable, JsonSerializable
{
    private array $collection = [];

    private int $position = 0;

    public static function create(CustomObject ...$objects): self
    {
        return new self(...$objects);
    }

    final private function __construct(CustomObject ...$objects)
    {
        $this->collection = $objects;
    }

    /** JsonSerializable **/
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
        return isset($this->collection[$this->position]);
    }
}
