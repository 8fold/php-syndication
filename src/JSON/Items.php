<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Implementations\CollectionJsonSerializableImp;

use Eightfold\Syndication\Json\Item;

class Items
implements Traversable, Iterator, Countable, JsonSerializable
{
    use CollectionJsonSerializableImp;

    public static function create(Item ...$items): self
    {
        return new self(...$items);
    }

    final private function __construct(Item ...$items)
    {
        $this->collection = $items;
    }
}
