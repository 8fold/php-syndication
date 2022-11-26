<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Rss\Item;

use Eightfold\Syndication\Implementations\CollectionStringableImp;

class Items implements Traversable, Iterator, Countable, Buildable
{
    use CollectionStringableImp;

    public static function create(Item ...$items): self
    {
        return new self(...$items);
    }

    final private function __construct(Item ...$items)
    {
        $this->collection = $items;
    }
}
