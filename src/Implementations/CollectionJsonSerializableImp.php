<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Implementations;

use Eightfold\Syndication\Implementations\CollectionImp as BaseCollectionImp;

trait CollectionJsonSerializableImp
{
    use BaseCollectionImp;

    public function jsonSerialize(): mixed
    {
        return $this->collection();
    }
}
