<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Author;

use Eightfold\Syndication\Atom\Implementations\CollectionImp;

class Authors implements Traversable, Iterator, Countable, Buildable
{
    use CollectionImp;

    public static function create(Author ...$authors): self
    {
        return new self(...$authors);
    }

    final private function __construct(Author ...$authors)
    {
        $this->collection = $authors;
    }
}
