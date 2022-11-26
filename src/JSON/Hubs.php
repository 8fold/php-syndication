<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Implementations\CollectionJsonSerializableImp;

use Eightfold\Syndication\Json\Hub;

class Hubs implements Traversable, Iterator, Countable, JsonSerializable
{
    use CollectionJsonSerializableImp;

    public static function create(Hub ...$hubs): self
    {
        return new self(...$hubs);
    }

    final private function __construct(Hub ...$hubs)
    {
        $this->collection = $hubs;
    }
}
