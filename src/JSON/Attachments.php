<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Traversable;
use Iterator;
use Countable;
use JsonSerializable;

use Eightfold\Syndication\Implementations\CollectionJsonSerializableImp;

use Eightfold\Syndication\Json\Attachment;

class Attachments implements Traversable, Iterator, Countable, JsonSerializable
{
    use CollectionJsonSerializableImp;

    public static function create(Attachment ...$attachments): self
    {
        return new self(...$attachments);
    }

    final private function __construct(Attachment ...$attachments)
    {
        $this->collection = $attachments;
    }
}
