<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Enclosure implements Stringable
{
    public static function create(
        string $url,
        string|int $length,
        string $type
    ): self {
        return new self($url, $length, $type);
    }

    final private function __construct(
        readonly private string $url,
        readonly private string|int $length,
        readonly private string $type
    ) {
    }

    public function __toString(): string
    {
        return (string) Element::enclosure()->props(
            'url ' . $this->url,
            'length ' . $this->length,
            'type ' . $this->type
        )->omitEndTag();
    }
}
