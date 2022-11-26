<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom\Abstracts;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Atom\Enums\TextTypes;

class TextElement implements Buildable
{
    public static function create(
        string $element,
        string $content,
        TextTypes $type = TextTypes::TEXT
    ): self {
        return new self($element, $content, $type);
    }

    final private function __construct(
        readonly private string $element,
        readonly private string $content,
        readonly private TextTypes $type
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $e = Element::{$this->element}($this->content);
        if ($this->type === TextTypes::TEXT) {
            return (string) $e;
        }
        return (string) $e->props('type ' . $this->type->value);
    }
}
