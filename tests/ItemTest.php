<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\RSS\Item;

use DateTime;

use Eightfold\Syndication\RSS\Category;
use Eightfold\Syndication\RSS\Enclosure;

use Eightfold\Syndication\RSS\Guid;
use Eightfold\Syndication\RSS\Source;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function can_have_source(): void
    {
        $expected = '<item><title>test</title><source url="http://static.userland.com/tomalak/links2.xml">Tomalak\'s Realm</source></item>';

        $result = (string) Item::create(
            title: 'test',
            source: Source::create(
                title: 'Tomalak\'s Realm',
                url: 'http://static.userland.com/tomalak/links2.xml'
            )
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_enclosure(): void
    {
        $expected = '<item><title>test</title><enclosure url="http://www.scripting.com/mp3s/weatherReportSuite.mp3" length="12216320" type="audio/mpeg" /></item>';

        $result = (string) Item::create(
            title: 'test',
            enclosure: Enclosure::create(
                url: 'http://www.scripting.com/mp3s/weatherReportSuite.mp3',
                length: '12216320',
                type: 'audio/mpeg'
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $result = (string) Item::create(
            title: 'test',
            enclosure: Enclosure::create(
                url: 'http://www.scripting.com/mp3s/weatherReportSuite.mp3',
                length: 12216320,
                type: 'audio/mpeg'
            )
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_categories(): void
    {
        $expected = 'Grateful Dead';

        $result = (string) Item::create(
            title: 'test'
        )->categories(
            Category::create($expected)
        );

        $this->assertSame(
            '<item><title>test</title><category>' . $expected . '</category></item>',
            $result
        );

        $result = (string) Item::create(
            title: 'test'
        )->categories(
            Category::create($expected),
            Category::create('MSFT', 'http://www.fool.com/cusips')
        );

        $this->assertSame(
            '<item><title>test</title><category>' . $expected . '</category><category domain="http://www.fool.com/cusips">MSFT</category></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_author_email(): void
    {
        $expected = 'someone@test.com';

        $result = (string) Item::create(
            title: 'test',
            author: $expected
        );

        $this->assertSame(
            '<item><title>test</title><author>' . $expected . '</author></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_comments_url(): void
    {
        $expected = 'http://scriptingnews.userland.com/backissues/2002/09/29#lawAndOrder';

        $result = (string) Item::create(
            title: 'test',
            comments: $expected
        );

        $this->assertSame(
            '<item><title>test</title><comments>' . $expected . '</comments></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_link_url(): void
    {
        $expected = 'http://scriptingnews.userland.com/backissues/2002/09/29#lawAndOrder';

        $result = (string) Item::create(
            title: 'test',
            link: $expected
        );

        $this->assertSame(
            '<item><title>test</title><link>' . $expected . '</link></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_guid_url(): void
    {
        $expected = 'http://scriptingnews.userland.com/backissues/2002/09/29#When:6:56:02PM';

        $result = (string) Item::create(
            title: 'test',
            guid: Guid::create($expected)
        );

        $this->assertSame(
            '<item><title>test</title><guid>' . $expected . '</guid></item>',
            $result
        );

        $result = (string) Item::create(
            title: 'test',
            guid: Guid::create($expected, true)
        );

        $this->assertSame(
            '<item><title>test</title><guid isPermaLink="true">' . $expected . '</guid></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function must_use_expected_date_format(): void
    {
        $expected = 'Mon, 30 Sep 2002 01:56:02 GMT';

        $result = (string) Item::create(
            title: 'test',
            pubDate: DateTime::createFromFormat(DateTime::RSS, $expected)
        );

        $this->assertSame(
            '<item><title>test</title><pubDate>' . $expected . '</pubDate></item>',
            $result
        );
    }

    /**
     * @test
     */
    public function must_have_title_or_description(): void
    {
        $expected = '';

        $result = (string) Item::create();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'has title';

        $result = (string) Item::create(title: $expected);

        $this->assertSame(
            '<item><title>' . $expected . '</title></item>',
            $result
        );

        $expected = 'has description';

        $result = (string) Item::create(description: $expected);

        $this->assertSame(
            '<item><description>' . $expected . '</description></item>',
            $result
        );
    }
}
