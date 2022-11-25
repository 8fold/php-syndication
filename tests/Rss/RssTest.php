<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use DateTime;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\DocumentRss;

use Eightfold\Syndication\Rss\Items;
use Eightfold\Syndication\Rss\Item;

use Eightfold\Syndication\RSS\Guid;

class RsTest extends TestCase
{
    /**
     * @test
     */
    public function can_output_sample_01(): void
    {
        $path = __DIR__ . '/sample-01.xml';

        $expected = htmlspecialchars_decode(file_get_contents($path));

        $result = (string) DocumentRss::create(
            title:       'Liftoff News',
            link:        'http://liftoff.msfc.nasa.gov/',
            description: 'Liftoff to Space Exploration.',
            items: Items::create(
                Item::create(
                    title: 'Star City',
                    link: 'http://liftoff.msfc.nasa.gov/news/2003/news-starcity.asp',
                    description: htmlspecialchars_decode('How do Americans get ready to work with Russians aboard the International Space Station? They take a crash course in culture, language and protocol at Russia\'s &lt;a href="http://howe.iki.rssi.ru/GCTC/gctc_e.htm"&gt;Star City&lt;/a&gt;.'),
                    pubDate: DateTime::createFromFormat(
                        DateTime::RSS,
                        'Tue, 03 Jun 2003 09:39:21 +0000'
                    ),
                    guid: Guid::create(
                        'http://liftoff.msfc.nasa.gov/2003/06/03.html#item573'
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
        )->withDocs('https://cyber.harvard.edu/rss/rss.html')->withGenerator(
            'Weblog Editor 2.0'
        )->withManagingEditor('editor@example.com')->withWebMaster(
            'webmaster@example.com'
        );

        $this->assertSame(
            $expected,
            $result . "\n"
        );
    }
}
