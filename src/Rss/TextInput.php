<?php
declare(strict_types=1);

namespace Eightfold\Syndication\RSS;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class TextInput implements Buildable
{
    public static function create(
        string $title,
        string $description,
        string $name,
        string $link
    ): self {
        return new self($title, $description, $name, $link);
    }

    final private function __construct(
        readonly private string $title,
        readonly private string $description,
        readonly private string $name,
        readonly private string $link
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return (string) Element::textInput(
            Element::title($this->title),
            Element::description($this->description),
            Element::name($this->name),
            Element::link($this->link)
        );
    }
}
