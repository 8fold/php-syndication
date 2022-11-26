<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class SkipHours implements Buildable
{
    /**
     * @var int[]
     */
    private array $hours = [];

    public static function create(int ...$hours): self
    {
        return new self(...$hours);
    }

    final private function __construct(int ...$hours)
    {
        $this->hours = array_unique($hours);
    }

    public function build(): string
    {
        return strval($this);
    }

    private function valid(): bool
    {
        return count($this->hours) > 0;
    }

    private function isInvalid(): bool
    {
        return ! $this->valid();
    }

    public function __toString(): string
    {
        if ($this->isInvalid()) {
            return '';
        }

        $h = [];
        foreach ($this->hours as $hour) {
            if ($hour >= 0 and $hour < 24) {
                $h[] = Element::hour(
                    strval($hour)
                );
            }

            if (count($h) === 24) {
                break;
            }
        }
        return (string) Element::skipHours(...$h);
    }
}
