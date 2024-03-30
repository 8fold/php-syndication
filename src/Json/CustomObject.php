<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use Stringable;
use JsonSerializable;

class CustomObject
{
    public static function create(
        string|Stringable $name,
        StdClass $object
    ): self {
        return new self($name, $object);
    }

    final private function __construct(
        readonly private string|Stringable $name,
        readonly private StdClass $object
    ) {
    }

    public function name(): string
    {
        $name = (string) $this->name;
        if (str_contains($name, '.')) {
            return '';
        }

        if (str_starts_with($name, '_')) {
            return $name;
        }
        return '_' . $name;
    }

    public function object(): StdClass
    {
        return $this->object;
    }

    /** JsonSerializable **/
    public function jsonSerialize(): mixed
    {
        $obj = new StdClass();

        if (strlen($this->name()) === 0) {
            return $obj;
        }

        $obj->{$this->name()} = $this->object;

        return $obj;
    }
}
