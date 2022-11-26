<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Rss\Category;

use Eightfold\Syndication\Implementations\CollectionStringableImp;

class Categories implements Traversable, Iterator, Countable, Buildable
{
    use CollectionStringableImp;

    public static function create(Category ...$categories): self
    {
        return new self(...$categories);
    }

    final private function __construct(Category ...$categories)
    {
        $this->collection = $categories;
    }
}
