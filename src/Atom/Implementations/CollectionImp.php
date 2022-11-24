<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom\Implementations;

trait CollectionImp
{
    private int|string $position = 0;

    private array $collection;

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $compiled = '';
        foreach ($this->collection as $c) {
            $compiled .= strval($c);
        }
        return $compiled;
    }

    /**
     * @return array<int|string, object>
     */
    public function collection(): array
    {
        return $this->collection;
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
