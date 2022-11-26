<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Json;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\DocumentJson;

use Eightfold\Syndication\Json\ContentHtml;

use Eightfold\Syndication\Json\Items;
use Eightfold\Syndication\Json\Item;

use Eightfold\Syndication\Json\Attachments;
use Eightfold\Syndication\Json\Attachment;

use Eightfold\Syndication\Json\Authors;
use Eightfold\Syndication\Json\Author;

use DateTime;

class JsonFeedTest extends TestCase
{
    /**
     * @test
     */
    public function can_output_sample_01(): void
    {
        $file = __DIR__ . '/sample-01.json';

        $expected = file_get_contents($file);

        $doc = DocumentJson::create(
            title: 'My Example Feed',
            homePageUrl: 'https://example.org/',
            feedUrl: 'https://example.org/feed.json',
            items: Items::create(
                Item::create(
                    id: '2',
                    content: 'This is a second item.'
                )->withUrl(
                    'https://example.org/second-item'
                ),
                Item::create(
                    id: '1',
                    content: ContentHtml::create('<p>Hello, world!</p>')
                )->withUrl(
                    'https://example.org/initial-post'
                )
            )
        );

        $result = json_encode(
            $doc,
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );

        $this->assertSame(
            $expected,
            $result . "\n"
        );
    }

    /**
     * @test
     */
    public function can_output_sample_03(): void
    {
        $file = __DIR__ . '/sample-03.json';

        $expected = file_get_contents($file);

        $doc = DocumentJson::create(
            title: 'Brent Simmons’s Microblog',
            homePageUrl: 'https://example.org/',
            feedUrl: 'https://example.org/feed.json',
            items: Items::create(
                Item::create(
                    id: '2347259',
                    // note: Using double prime because new line \n
                    content: "Cats are neat. \n\nhttps://example.org/cats"
                )->withUrl(
                    'https://example.org/2347259'
                )->withDatePublished(
                    DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2016-02-09T14:22:00-07:00'
                    )
                )
            )
        )->withAuthors(
            Authors::create(
                Author::create(
                    'Brent Simmons',
                    'http://example.org/',
                    'https://example.org/avatar.png'
                )
            )
        )->withUserComment(
            'This is a microblog feed. You can add this to your feed reader using the following URL: https://example.org/feed.json'
        );

        $result = json_encode(
            $doc,
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        $this->assertSame(
            $expected,
            $result . "\n"
        );
    }
}
