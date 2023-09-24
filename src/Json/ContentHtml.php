<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use Stringable;

class ContentHtml implements Stringable
{
    public static function create(string|Stringable $content): self
    {
        return new self($content);
    }

    final private function __construct(
        readonly private string|Stringable $content
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->content;
    }
}
