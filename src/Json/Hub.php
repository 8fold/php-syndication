<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use Stringable;
use JsonSerializable;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

class Hub implements JsonSerializable
{
    public static function create(
        string|Stringable $type,
        string|Stringable $url
    ): self {
        return new self($type, $url);
    }

    final private function __construct(
        readonly private string|Stringable $type,
        readonly private string|Stringable $url
    ) {
    }

    /** JsonSerializable **/
    public function jsonSerialize(): StdClass
    {
        $obj = new StdClass();
        $obj->type = $this->type;
        $obj->url = $this->url;

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
