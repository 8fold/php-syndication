<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Implementations\CollectionJsonSerializableImp;

use Eightfold\Syndication\Json\CustomObject;

class Authors
implements Traversable, Iterator, Countable, JsonSerializable
{
    use CollectionJsonSerializableImp;

    public static function create(CustomObject ...$objects): self
    {
        return new self(...$objects);
    }

    final private function __construct(CustomObject ...$objects)
    {
        $this->collection = $objects;
    }
}
