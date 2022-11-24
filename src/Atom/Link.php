<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class Link implements Buildable
{
    const ALTERNATE = 'alternate';
    const ENCLOSURE = 'enclosure';
    const RELATED = 'related';
    const SELF = 'self';
    const VIA = 'via';

    public static function create(
        string $href,
        string $rel = self::ALTERNATE
    ): self {
        return new self($href, $rel);
    }

    final private function __construct(
        readonly private string $href,
        readonly private string $rel = self::ALTERNATE
    ) {
    }

    public function isAlternate(): bool
    {
        return $this->rel === self::ALTERNATE;
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return (string) Element::link()->omitEndTag()->props(
            'href ' . $this->href,
            'rel ' . $this->rel
        );
    }
}
