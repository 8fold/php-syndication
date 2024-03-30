<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Source implements Stringable
{
    public static function create(
        string $title,
        string $url
    ): self {
        return new self($title, $url);
    }

    final private function __construct(
        readonly private string $title,
        readonly private string $url
    ) {
    }

    public function __toString(): string
    {
        return (string) Element::source($this->title)->props(
            'url ' . $this->url
        );
    }
}
