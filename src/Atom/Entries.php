<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;
use Stringable;

use Eightfold\Syndication\Atom\Entry;

class Entries implements Traversable, Iterator, Countable, Stringable
{
    private array $collection = [];

    private int $position = 0;

    public static function create(Entry ...$entries): self
    {
        return new self(...$entries);
    }

    final private function __construct(Entry ...$entries)
    {
        $this->collection = $entries;
    }

    public function isValid(): bool
    {
        foreach ($this as $entry) {
            if (
                is_object($entry) and
                is_a($entry, Entry::class) and
                $entry->isInvalid()
            ) {
                return false;
            }
        }
        return true;
    }

    /** Stringable **/
    public function __toString(): string
    {
        $compiled = '';
        foreach ($this->collection as $c) {
            $compiled .= strval($c);
        }
        return $compiled;
    }

    /**
     * JsonSerializable
     *
     * @return array<string, string>
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
