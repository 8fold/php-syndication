<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Link implements Stringable
{
    public const ALTERNATE = 'alternate';
    public const ENCLOSURE = 'enclosure';
    public const RELATED   = 'related';
    public const SELF      = 'self';
    public const VIA       = 'via';

    public static function create(
        string $href,
        string $rel = Link::ALTERNATE
    ): self {
        return new self($href, $rel);
    }

    final private function __construct(
        readonly private string $href,
        readonly private string $rel
    ) {
    }

    public function isAlternate(): bool
    {
        return $this->rel === Link::ALTERNATE;
    }

    public function __toString(): string
    {
        if ($this->rel === Link::ALTERNATE) {
            return (string) Element::link()->omitEndTag()->props(
                'href ' . $this->href,
            );
        }
        return (string) Element::link()->omitEndTag()->props(
            'href ' . $this->href,
            'rel ' . $this->rel
        );
    }
}
