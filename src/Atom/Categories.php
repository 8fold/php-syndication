<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Category;

use Eightfold\Syndication\Implementations\CollectionStringableImp;

class Categories implements Traversable, Iterator, Countable, Buildable
{
    use CollectionStringableImp;

    public static function create(Category ...$categories): self
    {
        return new self(...$contributors);
    }

    final private function __construct(Category ...$categories)
    {
        $this->collection = $contributors;
    }
}
