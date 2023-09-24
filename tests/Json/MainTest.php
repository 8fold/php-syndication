<?php
declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests\Extensions\Syndication\Json;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Json\Document;

use Eightfold\Syndication\Json\ContentHtml;

use Eightfold\Syndication\Json\Items;
use Eightfold\Syndication\Json\Item;

use Eightfold\Syndication\Json\Attachments;
use Eightfold\Syndication\Json\Attachment;

use Eightfold\Syndication\Json\Authors;
use Eightfold\Syndication\Json\Author;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

use DateTime;
use StdClass;

class MainTest extends TestCase
{
    /**
     * @test
     */
    public function can_output_sample_01(): void
    {
        $file = __DIR__ . '/samples/01.json';

        $expected = file_get_contents($file);

        $doc = Document::create(
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
    public function can_output_sample_02(): void
    {
        $file = __DIR__ . '/samples/02.json';

        $expected = file_get_contents($file);

        $doc = Document::create(
            title: 'The Record',
            homePageUrl: 'http://therecord.co/',
            feedUrl: 'http://therecord.co/feed.json',
            items: Items::create(
                Item::create(
                    id: 'http://therecord.co/chris-parrish',
                    content: 'Chris has worked at Adobe and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped Napkin, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on Bainbridge Island, a quick ferry ride from Seattle.'
                )->withExtraContent(
                    ContentHtml::create(
                        'Chris has worked at <a href="http://adobe.com/">Adobe</a> and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped <a href="http://aged-and-distilled.com/napkin/">Napkin</a>, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on <a href="http://www.ci.bainbridge-isl.wa.us/">Bainbridge Island</a>, a quick ferry ride from Seattle.'
                    )
                )->withUrl(
                    'http://therecord.co/chris-parrish'
                )->withTitle(
                    'Special #1 - Chris Parrish'
                )->withSummary(
                    'Brent interviews Chris Parrish, co-host of The Record and one-half of Aged & Distilled.'
                )->withDatePublished(
                    DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2014-05-09T14:04:00-07:00'
                    )
                )->withAttachments(
                    Attachments::create(
                        Attachment::create(
                            url: 'http://therecord.co/downloads/The-Record-sp1e1-ChrisParrish.m4a',
                            mimeType: 'audio/x-m4a',
                            size: 89970236,
                            duration: 6629
                        )
                    )
                )
            )
        )->withUserComment(
            'This is a podcast feed. You can add this feed to your podcast client using the following URL: http://therecord.co/feed.json'
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

    /**
     * @test
     */
    public function can_output_sample_03(): void
    {
        $file = __DIR__ . '/samples/03.json';

        $expected = file_get_contents($file);

        $doc = Document::create(
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

    /**
     * @test
     */
    public function can_handle_extensions(): void
    {
        $file = __DIR__ . '/samples/extended.json';

        $expected = file_get_contents($file);

        $customObject = new StdClass();
        $customObject->about = 'https://blueshed-podcasts.com/json-feed-extension-docs';
        $customObject->explicit = false;
        $customObject->copyright = '1948 by George Orwell';
        $customObject->owner = 'Big Brother and the Holding Company';
        $customObject->subtitle = 'All shouting, all the time. Double. Plus. Good.';

        $doc = Document::create(
            title: 'My Example Feed',
            items: Items::create(
                Item::create(
                    id: '2',
                    content: 'This is a second item.'
                )->withExtensions(
                    CustomObjects::create(
                        CustomObject::create('_blue_shed', $customObject)
                    )
                )
            )
        )->withExtensions(
            CustomObjects::create(
                CustomObject::create('_blue_shed', $customObject)
            )
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
