<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use stdClass;
use Stringable;
use JsonSerializable;

class CustomObject
{
    public static function create(
        string|Stringable $name,
        stdClass $object
    ): self {
        return new self($name, $object);
    }

    final private function __construct(
        readonly private string|Stringable $name,
        readonly private stdClass $object
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

    public function object(): stdClass
    {
        return $this->object;
    }

    /** JsonSerializable **/
    public function jsonSerialize(): stdClass
    {
        $obj = new stdClass();

        if (strlen($this->name()) === 0) {
            return $obj;
        }

        $obj->{$this->name()} = $this->object;

        return $obj;
    }
}
