<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\SkipDays;

class SkipDaysTest extends TestCase
{
    public function test_has_days(): void
    {
        $expected = '';

        $result = (string) SkipDays::create();

        parent::assertSame(
            $expected,
            $result
        );

        $expected = '<skipDays><day>Monday</day></skipDays>';

        $result = (string) SkipDays::create(
            SkipDays::MONDAY
        );

        parent::assertSame(
            $expected,
            $result
        );
    }

    public function test_no_duplicate_days(): void
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

        parent::assertSame(
            $expected,
            $result
        );
    }
}
