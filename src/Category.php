<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class Category implements Buildable
{
    public static function create(string $category, string $domain = ''): self
    {
        return new self($category, $domain);
    }

    final private function __construct(
        readonly private string $category,
        readonly private string $domain = ''
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        if (strlen($this->domain) > 0) {
            return (string) Element::category($this->category)->props(
                'domain ' . $this->domain
            );
        }
        return (string) Element::category($this->category);
    }
}
