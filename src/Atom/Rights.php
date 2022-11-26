<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Syndication\Atom\Abstracts\TextElement;
use Eightfold\Syndication\Atom\Enums\TextTypes;

class Rights implements Buildable
{
    public static function create(
        string $content,
        TextTypes $type = TextTypes::TEXT
    ): self {
        return new self($content, $type);
    }

    final private function __construct(
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
        return (string) TextElement::create('rights', $this->content, $this->type);
    }
}
