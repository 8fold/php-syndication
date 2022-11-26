<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use JsonSerializable;

class Author implements JsonSerializable
{
    public static function create(
        string $name = '',
        string $url = '',
        string $avatar = ''
    ): self {
        return new self($name, $url, $avatar);
    }

    final private function __construct(
        readonly private string $name = '',
        readonly private string $url = '',
        readonly private string $avatar = ''
    ) {
    }

    public function jsonSerialize(): mixed
    {
        $obj = new StdClass();

        if (strlen($this->name) > 0) {
            $obj->name = $this->name;
        }

        if (strlen($this->url) > 0) {
            $obj->url = $this->url;
        }

        if (strlen($this->avatar) > 0) {
            $obj->avatar = $this->avatar;
        }

        return $obj;
    }
}
