<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Eightfold\XMLBuilder\Contracts\Buildable;

class ContentHtml implements Buildable
{
    public static function create(string $content): self
    {
        return new self($content);
    }

    final private function __construct(readonly private string $content)
    {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
