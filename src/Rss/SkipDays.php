<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Rss\Enums\SkipDaysDay;

class SkipDays implements Stringable
{
    public const MONDAY    = 'Monday';
    public const TUESDAY   = 'Tuesday';
    public const WEDNESDAY = 'Wednesday';
    public const THURSDAY  = 'Thursday';
    public const FRIDAY    = 'Friday';
    public const SATURDAY  = 'Saturday';
    public const SUNDAY    = 'Sunday';

    /**
     * @var string[]
     */
    private array $days = [];

    public static function create(string ...$days): self
    {
        return new self(...$days);
    }

    final private function __construct(string ...$days)
    {
        foreach ($days as $day) {
            if (in_array($day, $this->days) === false) {
                $this->days[] = $day;
            }
        }
    }

    public function build(): string
    {
        return strval($this);
    }

    private function valid(): bool
    {
        return count($this->days) > 0;
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

        $d = [];
        foreach ($this->days as $day) {
            $d[] = Element::day($day);
        }
        return (string) Element::skipDays(...$d);
    }
}
