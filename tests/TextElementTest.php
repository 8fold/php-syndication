<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Atom\Entry;

use DateTime;

use Eightfold\Syndication\Atom\Content;

use Eightfold\Syndication\Atom\Abstracts\TextElement;

class TextElementTest extends TestCase
{
    /**
     * @test
     */
    public function can_specify_text_element_type(): void
    {
        $expected = '<content>Content</content>';

        $result = (string) Content::create('Content');

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<content type="html">Content</content>';

        $result = (string) Content::create(
            'Content',
            TextElement::HTML
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<content type="xhtml">Content</content>';

        $result = (string) Content::create(
            'Content',
            TextElement::XHTML
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
