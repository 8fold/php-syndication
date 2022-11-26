<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Atom\Enums\LinkRel;

class Link implements Buildable
{
    public static function create(
        string $href,
        LinkRel $rel = LinkRel::ALTERNATE
    ): self {
        return new self($href, $rel);
    }

    final private function __construct(
        readonly private string $href,
        readonly private LinkRel $rel
    ) {
    }

    public function isAlternate(): bool
    {
        return $this->rel === LinkRel::ALTERNATE;
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        if ($this->rel === LinkRel::ALTERNATE) {
            return (string) Element::link()->omitEndTag()->props(
                'href ' . $this->href,
            );
        }
        return (string) Element::link()->omitEndTag()->props(
            'href ' . $this->href,
            'rel ' . $this->rel->value
        );
    }
}
