<?php
declare(strict_types=1);

namespace Eightfold\Syndication\JSON;

use StdClass;
use JsonSerializable;

class Attachment implements JsonSerializable
{
    public static function create(
        string $url,
        string $mimeType,
        string $title = '',
        int $size = 0.
        int $duration = 0
    ): self {
        return new self($url, $mimeType, $title, $size, $duration);
    }

    final private function __construct(
        readonly private string $url,
        readonly private string $mimeType,
        readonly private string $title = ''
        readonly private int $size = 0,
        readonly private int $duration = 0
    ) {
    }

    public function jsonSerialize(): mixed
    {
        $obj = new StdClass();
        $obj->url = $this->url;
        $obj->mime_type = $this->mimeType;

        if (strlen($this->title) > 0) {
            $obj->title = $this->title;
        }

        if ($this->size > 0) {
            $obj->size_in_bytes = $this->size;
        }

        if ($this->duration > 0) {
            $obj->duration_in_seconds = $this->duration;
        }

        return $obj;
    }
}
