<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Link;

use Eightfold\Syndication\Atom\Implementations\CollectionImp;

class Links implements Traversable, Iterator, Countable, Buildable
{
    use CollectionImp;

    public static function create(Link ...$links): self
    {
        return new self(...$links);
    }

    final private function __construct(Link ...$links)
    {
        $this->collection = $links;
    }
}
