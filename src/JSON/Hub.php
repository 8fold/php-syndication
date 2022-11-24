<?php
declare(strict_types=1);

namespace Eightfold\Syndication\JSON;

use StdClass;
use JsonSerializable;

class Hub implements JsonSerializable
{
    public static function create(
        string $type,
        string $url
    ): self {
        return new self($type, $url);
    }

    final private function __construct(
        readonly private string $type,
        readonly private string $url
    ) {
    }

    public function jsonSerialize(): mixed
    {
        $obj = new StdClass();
        $obj->type = $this->type;
        $obj->url = $this->url;

        return $obj;
    }
}
