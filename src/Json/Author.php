<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use Stringable;
use JsonSerializable;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

class Author implements JsonSerializable
{
    private CustomObjects $customObjects;

    public static function create(
        string|Stringable $name = '',
        string|Stringable $url = '',
        string|Stringable $avatar = ''
    ): self {
        return new self($name, $url, $avatar);
    }

    final private function __construct(
        readonly private string|Stringable $name = '',
        readonly private string|Stringable $url = '',
        readonly private string|Stringable $avatar = ''
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

    private function name(): string
    {
        return (string) $this->name;
    }

    private function url(): string
    {
        return (string) $this->url;
    }

    private function avatar(): string
    {
        return (string) $this->avatar;
    }

    /** JsonSerializable **/
    public function jsonSerialize(): StdClass
    {
        $obj = new StdClass();

        if (strlen($this->name()) > 0) {
            $obj->name = $this->name();
        }

        if (strlen($this->url()) > 0) {
            $obj->url = $this->url();
        }

        if (strlen($this->avatar()) > 0) {
            $obj->avatar = (string) $this->avatar();
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
