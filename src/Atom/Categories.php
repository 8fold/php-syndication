<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Iterator;
use Countable;
use Stringable;

use Eightfold\Syndication\Atom\Category;

/**
 * @implements Iterator<int, Category>
 */
class Categories implements Iterator, Countable, Stringable
{
    /**
     * @var list<Category>
     */
    private array $collection = [];

    private int $position = 0;

    public static function create(Category ...$categories): self
    {
        return new self(...$categories);
    }

    final private function __construct(Category ...$categories)
    {
        $this->collection = array_values($categories);
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
     * @return list<Category>
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
