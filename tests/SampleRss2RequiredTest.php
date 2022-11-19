<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Document;

use Eightfold\Syndication\Item;

use DateTime;

class SampleRss2RequiredTest extends TestCase
{
    /**
     * @test
     */
    public function can_render_sample_file_from_spec(): void
    {
        $path = __DIR__ . '/examples/sample-rss-2-required.xml';

        $this->assertTrue(
            file_exists($path)
        );

        $expected = htmlspecialchars_decode(file_get_contents($path));

        $this->assertNotFalse(
            $expected
        );

        $result = (string) Document::rss(
            title:       'Scripting News',
            link:        'http://www.scripting.com/',
            description: 'A weblog about scripting and stuff like that.'
        )->items(
            Item::create(
                description: '"rssflowersalignright"With any luck we should have one or two more days of namespaces stuff here on Scripting News. It feels like it\'s winding down. Later in the week I\'m going to a <a href="http://harvardbusinessonline.hbsp.harvard.edu/b02/en/conferences/conf_detail.jhtml?id=s775stg&pid=144XCF">conference</a> put on by the Harvard Business School. So that should change the topic a bit. The following week I\'m off to Colorado for the <a href="http://www.digitalidworld.com/conference/2002/index.php">Digital ID World</a> conference. We had to go through namespaces, and it turns out that weblogs are a great way to work around mail lists that are clogged with <a href="http://www.userland.com/whatIsStopEnergy">stop energy</a>. I think we solved the problem, have reached a consensus, and will be ready to move forward shortly.'
            ),
            Item::create(
                title: 'Law and Order'
            )
        );

        $this->assertSame(
            $expected,
            $result . "\n"
        );
    }
}
