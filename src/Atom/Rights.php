<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Abstracts\TextElement;

class Rights implements Buildable
{
    public static function create(
        string $content,
        string $type = TextElement::TEXT
    ): self {
        return new self($content, $type);
    }

    final private function __construct(
        readonly private string $content,
        readonly private string $type = TextElement::TEXT
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return (string) TextElement::create('rights', $this->content, $this->type);
    }
}
