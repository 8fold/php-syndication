<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\SkipDays;
use Eightfold\Syndication\Rss\Enums\SkipDaysDay;

class SkipDaysTest extends TestCase
{
    /**
     * @test
     */
    public function has_days(): void
    {
        $expected = '';

        $result = (string) SkipDays::create();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<skipDays><day>Monday</day></skipDays>';

        $result = (string) SkipDays::create(
            SkipDaysDay::MONDAY
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function no_duplicate_days(): void
    {
        $expected = '<skipDays><day>Monday</day><day>Tuesday</day></skipDays>';

        $result = (string) SkipDays::create(
            SkipDaysDay::MONDAY,
            SkipDaysDay::MONDAY,
            SkipDaysDay::MONDAY,
            SkipDaysDay::TUESDAY,
            SkipDaysDay::TUESDAY,
            SkipDaysDay::MONDAY,
            SkipDaysDay::MONDAY,
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
