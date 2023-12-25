<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Image implements Stringable
{
    public static function create(
        string $url,
        string $title,
        string $link,
        int $width = 88,
        int $height = 31,
        string $description = ''
    ): self {
        return new self(
            $url,
            $title,
            $link,
            $width,
            $height,
            $description
        );
    }

    final private function __construct(
        readonly private string $url,
        readonly private string $title,
        readonly private string $link,
        private int $width = 88,
        private int $height = 31,
        readonly private string $description = ''
    ) {
        if ($width > 144) {
            $this->width = 144;
        }

        if ($height > 400) {
            $this->height = 400;
        }
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $width = '';
        if ($this->width !== 88) {
            $width = Element::width(
                strval($this->width)
            );
        }

        $height = '';
        if ($this->height !== 31) {
            $height = Element::height(
                strval($this->height)
            );
        }

        $description = '';
        if (strlen($this->description) > 0) {
            $description = Element::description($this->description);
        }

        return (string) Element::image(
            Element::url($this->url),
            Element::title($this->title),
            Element::link($this->link),
            $width,
            $height,
            $description
        );
    }
}
