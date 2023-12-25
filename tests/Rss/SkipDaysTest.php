<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\SkipDays;

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
            SkipDays::MONDAY
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
            SkipDays::MONDAY,
            SkipDays::MONDAY,
            SkipDays::MONDAY,
            SkipDays::TUESDAY,
            SkipDays::TUESDAY,
            SkipDays::MONDAY,
            SkipDays::MONDAY,
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
