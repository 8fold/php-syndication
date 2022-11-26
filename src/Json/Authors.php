<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Implementations\CollectionJsonSerializableImp;

use Eightfold\Syndication\Json\Author;

class Authors implements Traversable, Iterator, Countable, JsonSerializable
{
    use CollectionJsonSerializableImp;

    public static function create(Author ...$authors): self
    {
        return new self(...$authors);
    }

    final private function __construct(Author ...$authors)
    {
        $this->collection = $authors;
    }
}
