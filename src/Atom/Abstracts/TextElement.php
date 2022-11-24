<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom\Abstracts;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class TextElement implements Buildable
{
    const TEXT = 'text';
    const HTML = 'html';
    const XHTML = 'xhtml';

    public static function create(
        string $element,
        string $content,
        string $type = self::TEXT
    ): self {
        return new self($element, $content, $type);
    }

    final private function __construct(
        readonly private string $element,
        readonly private string $content,
        readonly private string $type = self::TEXT
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $e = Element::{$this->element}($this->content);
        if ($this->type === self::TEXT) {
            return (string) $e;
        }
        return (string) $e->props('type ' . $this->type);
    }
}
