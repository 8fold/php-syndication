<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\Image;

class ImageTest extends TestCase
{
    public function test_has_required_aspects(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed'
        );

        parent::assertSame(
            $expected,
            $result
        );
    }

    public function test_can_have_width(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><width>144</width></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            width: 200
        );

        parent::assertSame(
            $expected,
            $result
        );
    }

    public function test_can_have_height(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><height>400</height></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            height: 500
        );

        parent::assertSame(
            $expected,
            $result
        );
    }

    public function test_can_have_description(): void
    {
        // phpcs:disable
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><description>description</description></image>';
        // phpcs:enable

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            description: 'description'
        );

        parent::assertSame(
            $expected,
            $result
        );
    }
}
