<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use DateTime;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Document;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Content;
use Eightfold\Syndication\Atom\Authors;
use Eightfold\Syndication\Atom\Author;
use Eightfold\Syndication\Atom\Links;
use Eightfold\Syndication\Atom\Link;
use Eightfold\Syndication\Atom\Entry;

class SampleAtom1OriginalTest extends TestCase
{
    /**
     * @test
     */
    public function must_not_have_more_than_one_alternate_link(): void
    {
        $expected = '';

        $result = (string) Document::atom(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string',
            links: Links::create(
                Link::create(
                    href: '/feed'
                ),
                Link::create(
                    href: '/feed',
                    rel: Link::ALTERNATE
                )
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><title>Scripting News</title><id href="some_unique_string" /><updated>2003-12-13T18:30:02+00:00</updated><link href="/feed" rel="alternate" /><link href="/feed" rel="self" /></feed>
        xml;

        $result = (string) Document::atom(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string',
            links: Links::create(
                Link::create(
                    href: '/feed'
                ),
                Link::create(
                    href: '/feed',
                    rel: 'self'
                )
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
    public function must_have_at_least_one_author(): void
    {
        $expected = '';

        $result = (string) Document::atom(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string'
        )->withEntries(
            Entry::create(
                title: Title::create('Title'),
                updated: DateTime::createFromFormat(
                    DateTime::ATOM,
                    '2003-12-13T18:30:02Z'
                ),
                id: 'some_unique_string'
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><title>Scripting News</title><id href="some_unique_string" /><updated>2003-12-13T18:30:02+00:00</updated><author><name>John Doe</name></author><author><name>Jane Doe</name></author><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><content>Hello, World!</content></entry></feed>
        xml;

        $result = (string) Document::atom(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string',
            authors: Authors::create(
                Author::create('John Doe'),
                Author::create('Jane Doe')
            )
        )->withEntries(
            Entry::create(
                title: Title::create('Title'),
                updated: DateTime::createFromFormat(
                    DateTime::ATOM,
                    '2003-12-13T18:30:02Z'
                ),
                id: 'some_unique_string',
                content: Content::create('Hello, World!')
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><title>Scripting News</title><id href="some_unique_string" /><updated>2003-12-13T18:30:02+00:00</updated><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name></author><content>Hello, World!</content></entry><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><author><name>Jane Doe</name></author><content>Hello, World!</content></entry></feed>
        xml;

        $result = (string) Document::atom(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string'
        )->withEntries(
            Entry::create(
                title: Title::create('Title'),
                updated: DateTime::createFromFormat(
                    DateTime::ATOM,
                    '2003-12-13T18:30:02Z'
                ),
                id: 'some_unique_string',
                authors: Authors::create(
                    Author::create('John Doe')
                ),
                content: Content::create('Hello, World!')
            ),
            Entry::create(
                title: Title::create('Title'),
                updated: DateTime::createFromFormat(
                    DateTime::ATOM,
                    '2003-12-13T18:30:02Z'
                ),
                id: 'some_unique_string',
                authors: Authors::create(
                    Author::create('Jane Doe')
                ),
                content: Content::create('Hello, World!')
            )
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
