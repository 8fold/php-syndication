<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Iterator;
use Countable;
use Stringable;

use Eightfold\Syndication\Atom\Entry;

/**
 * @implements Iterator<int, Entry>
 */
class Entries implements Iterator, Countable, Stringable
{
    /**
     * @var list<Entry>
     */
    private array $collection = [];

    private int $position = 0;

    public static function create(Entry ...$entries): self
    {
        return new self(...$entries);
    }

    final private function __construct(Entry ...$entries)
    {
        $this->collection = array_values($entries);
    }

    public function isValid(): bool
    {
        foreach ($this as $entry) {
            if ($entry->isInvalid()) {
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
     * @return list<Entry>
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
