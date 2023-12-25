<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Guid implements Stringable
{
    public static function create(string $guid, bool $isPermaLink = false): self
    {
        return new self($guid, $isPermaLink);
    }

    final private function __construct(
        readonly private string $guid,
        readonly private bool $isPermaLink = false
    ) {
    }

    public function __toString(): string
    {
        if ($this->isPermaLink) {
            return (string) Element::guid($this->guid)->props('isPermaLink true');
        }
        return (string) Element::guid($this->guid);
    }
}
