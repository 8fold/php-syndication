<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use DateTime;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\Document;

use Eightfold\Syndication\Rss\Items;
use Eightfold\Syndication\Rss\Item;

use Eightfold\Syndication\Rss\Guid;

class RssTest extends TestCase
{
    public function test_required_fields_are_required_by_initializer(): void
    {
        $expected = '';

        $result = (string) Document::create(
            title: 'title',
            link: '/feed',
            description: 'description',
            items: Items::create()
        );

        parent::assertSame(
            $expected,
            $result
        );

        $file = __DIR__ . '/samples/required-01.xml';

        $expected = file_get_contents($file);

        $result = (string) Document::create(
            title: 'title',
            link: '/feed',
            description: 'description',
            items: Items::create(
                Item::create(
                    title: 'item title'
                )
            )
        );

        parent::assertSame(
            $expected,
            $result . "\n"
        );

        $file = __DIR__ . '/samples/required-02.xml';

        $expected = file_get_contents($file);

        $result = (string) Document::create(
            title: 'title',
            link: '/feed',
            description: 'description',
            items: Items::create(
                Item::create(
                    description: 'item description'
                )
            )
        );

        parent::assertSame(
            $expected,
            $result . "\n"
        );
    }

    public function test_can_output_sample_01(): void
    {
        $path = __DIR__ . '/samples/01.xml';

        $content = file_get_contents($path);
        parent::assertNotFalse($content);

        $expected = htmlspecialchars_decode($content);

        $result = (string) Document::create(
            title:       'Liftoff News',
            link:        'http://liftoff.msfc.nasa.gov/',
            description: 'Liftoff to Space Exploration.',
            items: Items::create(
                Item::create(
                    title: 'Star City',
                    description: htmlspecialchars_decode(
                        'How do Americans get ready to work with Russians aboard the International Space Station? They take a crash course in culture, language and protocol at Russia\'s &lt;a href="http://howe.iki.rssi.ru/GCTC/gctc_e.htm"&gt;Star City&lt;/a&gt;.' // phpcs:ignore
                    )
                )->withLink(
                    'http://liftoff.msfc.nasa.gov/news/2003/news-starcity.asp'
                )->withGuid(
                    Guid::create(
                        'http://liftoff.msfc.nasa.gov/2003/06/03.html#item573'
                    )
                )->withPubDate(
                    DateTime::createFromFormat(
                        DateTime::RSS,
                        'Tue, 03 Jun 2003 09:39:21 +0000'
                    )
                ),
                Item::create(
                    description: 'Sky watchers in Europe, Asia, and parts of Alaska and Canada will experience a <a href="http://science.nasa.gov/headlines/y2003/30may_solareclipse.htm">partial eclipse of the Sun</a> on Saturday, May 31st.' // phpcs:ignore
                )->withGuid(
                    Guid::create(
                        'http://liftoff.msfc.nasa.gov/2003/05/30.html#item572'
                    )
                )->withPubDate(
                    DateTime::createFromFormat(
                        DateTime::RSS,
                        'Fri, 30 May 2003 11:06:42 +0000'
                    )
                ),
                Item::create(
                    title: 'The Engine That Does More',
                    description: 'Before man travels to Mars, NASA hopes to design new engines that will let us fly through the Solar System more quickly.  The proposed VASIMR engine would do that.' // phpcs:ignore
                )->withLink(
                    'http://liftoff.msfc.nasa.gov/news/2003/news-VASIMR.asp'
                )->withGuid(
                    Guid::create(
                        'http://liftoff.msfc.nasa.gov/2003/05/27.html#item571'
                    )
                )->withPubDate(
                    DateTime::createFromFormat(
                        DateTime::RSS,
                        'Tue, 27 May 2003 08:37:32 +0000'
                    )
                ),
                Item::create(
                    title: 'Astronauts\' Dirty Laundry',
                    description: 'Compared to earlier spacecraft, the International Space Station has many luxuries, but laundry facilities are not one of them.  Instead, astronauts have other options.' // phpcs:ignore
                )->withLink(
                    'http://liftoff.msfc.nasa.gov/news/2003/news-laundry.asp'
                )->withGuid(
                    Guid::create(
                        'http://liftoff.msfc.nasa.gov/2003/05/20.html#item570'
                    )
                )->withPubDate(
                    DateTime::createFromFormat(
                        DateTime::RSS,
                        'Tue, 20 May 2003 08:56:02 +0000'
                    )
                )
            )
        )->withLanguage('en-us')->withPubDate(
            DateTime::createFromFormat(
                DateTime::RSS,
                'Tue, 10 Jun 2003 04:00:00 GMT'
            )
        )->withLastBuildDate(
            DateTime::createFromFormat(
                DateTime::RSS,
                'Tue, 10 Jun 2003 09:41:01 +0000'
            )
        )->withDocs(
            'https://cyber.harvard.edu/rss/rss.html'
        )->withGenerator(
            'Weblog Editor 2.0'
        )->withManagingEditor(
            'editor@example.com'
        )->withWebMaster(
            'webmaster@example.com'
        );

        parent::assertSame(
            $expected,
            $result . "\n"
        );
    }
}
