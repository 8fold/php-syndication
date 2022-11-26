<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Implementations;

use Eightfold\Syndication\Implementations\CollectionImp as BaseCollectionImp;

trait CollectionStringableImp
{
    use BaseCollectionImp;

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $compiled = '';
        foreach ($this->collection as $c) {
            $compiled .= strval($c);
        }
        return $compiled;
    }
}
