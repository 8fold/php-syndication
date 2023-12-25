<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;

use DateTime;

use Eightfold\XMLBuilder\Element;

class Category implements Stringable
{
    public static function create(
        string $term,
        string $scheme = '',
        string $label = ''
    ): self {
        return new self($term, $scheme, $label);
    }

    final private function __construct(
        readonly private string $term,
        readonly private string $scheme = '',
        readonly private string $label = ''
    ) {
    }

    public function __toString(): string
    {
        $props = [
            'term ' . $this->term
        ];

        if (strlen($this->scheme) === 0) {
            $props[] = 'scheme ' . $this->scheme;
        }

        if (strlen($this->label) === 0) {
            $props[] = 'lable ' . $this->label;
        }

        return (string) Element::category(...$props);
    }
}
