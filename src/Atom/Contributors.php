<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Traversable;
use Iterator;
use Countable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Contributor;

use Eightfold\Syndication\Atom\Implementations\CollectionImp;

class Contributors implements Traversable, Iterator, Countable, Buildable
{
    use CollectionImp;

    public static function create(Contributor ...$contributors): self
    {
        return new self(...$contributors);
    }

    final private function __construct(Contributor ...$contributors)
    {
        $this->collection = $contributors;
    }
}
