<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use Stringable;
use JsonSerializable;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

class Attachment implements JsonSerializable
{
    private CusstomObjects $customObjects;

    public static function create(
        string|Stringable $url,
        string|Stringable $mimeType,
        string|Stringable $title = '',
        int $size = 0,
        int $duration = 0
    ): self {
        return new self($url, $mimeType, $title, $size, $duration);
    }

    final private function __construct(
        readonly private string|Stringable $url,
        readonly private string|Stringable $mimeType,
        readonly private string|Stringable $title = '',
        readonly private int $size = 0,
        readonly private int $duration = 0
    ) {
    }

    public function withCustomObjects(CustomObjects $customObjects): self
    {
        $this->customObjects = $customObjects;
        return $this;
    }

    public function withExtensions(CustomObjects $customObjects): self
    {
        return $this->withCustomObjects($customObjects);
    }

    /** JsonSerializable **/
    public function jsonSerialize(): StdClass
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

        if (isset($this->customObjects)) {
            foreach ($this->customObjects as $customObject) {
                if (is_a($customObject, CustomObject::class)) {
                    $name = $customObject->name();
                    $obj->{$name} = $customObject->object();
                }
            }
        }

        return $obj;
    }
}
