<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;

use Eightfold\Syndication\Atom\TextElement;

use Eightfold\Syndication\Atom\TextTypes;

class Content implements Stringable
{
    public static function create(
        string $content,
        string $type = TextTypes::TEXT
    ): self {
        return new self($content, $type);
    }

    final private function __construct(
        readonly private string $content,
        readonly private string $type
    ) {
    }

    public function __toString(): string
    {
        return (string) TextElement::create(
            'content',
            $this->content,
            $this->type
        );
    }
}
