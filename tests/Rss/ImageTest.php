<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\Image;

class ImageTest extends TestCase
{
    /**
     * @test
     */
    public function has_required_aspects(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed'
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_width(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><width>144</width></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            width: 200
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_height(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><height>400</height></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            height: 500
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_description(): void
    {
        $expected = '<image><url>/image.png</url><title>title</title><link>/feed</link><description>description</description></image>';

        $result = (string) Image::create(
            '/image.png',
            'title',
            '/feed',
            description: 'description'
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
