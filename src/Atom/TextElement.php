<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Atom\TextTypes;

class TextElement implements Stringable
{
    public static function create(
        string $element,
        string $content,
        string $type = TextTypes::TEXT
    ): self {
        return new self($element, $content, $type);
    }

    final private function __construct(
        readonly private string $element,
        readonly private string $content,
        readonly private string $type
    ) {
    }

    public function __toString(): string
    {
        $e = Element::{$this->element}($this->content);
        if ($this->type === TextTypes::TEXT) {
            return (string) $e;
        }
        return (string) $e->props('type ' . $this->type);
    }
}
