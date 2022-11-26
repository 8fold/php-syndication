<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Entry;

use Eightfold\Syndication\Implementations\CollectionStringableImp;

class Entries implements Traversable, Iterator, Countable, Buildable
{
    use CollectionStringableImp;

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
            if ($entry->isInvalid()) {
                return false;
            }
        }
        return true;
    }
}
