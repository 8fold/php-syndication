<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use DateTime;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Document;

use Eightfold\Syndication\JSON\Items;
use Eightfold\Syndication\JSON\Item;

class SampleJson1OriginalTest extends TestCase
{
    /**
     * @test
     */
    public function must_have_required_properties(): void
    {
        $expected = <<<json
        {
            "version": "https://jsonfeed.org/version/1.1",
            "title": "some title",
            "items": [
                {
                    "id": "id",
                    "content_text": "Some text content"
                }
            ]
        }
        json;

        $result = json_encode(
            Document::json(
                'some title',
                Items::create(
                    Item::create(
                        'id',
                        'Some text content'
                    )
                )
            ),
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
