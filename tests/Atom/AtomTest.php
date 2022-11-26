<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\DocumentAtom;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Content;
use Eightfold\Syndication\Atom\Summary;

use Eightfold\Syndication\Atom\Authors;
use Eightfold\Syndication\Atom\Author;

use Eightfold\Syndication\Atom\Links;
use Eightfold\Syndication\Atom\Link;

use Eightfold\Syndication\Atom\Enums\LinkRel;

use Eightfold\Syndication\Atom\Entries;
use Eightfold\Syndication\Atom\Entry;

use DateTime;

class AtomTest extends TestCase
{
    /**
     * @test
     */
    public function can_output_sample_01(): void
    {
        $file = __DIR__ . '/sample-01.xml';

        $expected = file_get_contents($file);

        $result = (string) DocumentAtom::create(
            id: 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6',
            title: Title::create('Example Feed'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z',
            ),
            authors: Authors::create(
                Author::create('John Doe')
            ),
            links: Links::create(
                Link::create('http://example.org/')
            ),
            entries: Entries::create(
                Entry::create(
                    title: Title::create('Atom-Powered Robots Run Amok'),
                    id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
                    updated: DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2003-12-13T18:30:02Z'
                    ),
                    summary: Summary::create('Some text.'),
                    links: Links::create(
                        Link::create(
                            href: 'http://example.org/2003/12/13/atom03'
                        )
                    )
                )
            )
        )->xmlDeclaration();

        $this->assertSame(
            $expected,
            $result . "\n"
        );
    }

    /**
     * @test
     */
    public function must_not_have_more_than_one_alternate_link(): void
    {
        $expected = '';

        $result = (string) DocumentAtom::create(
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
                    rel: LinkRel::ALTERNATE
                )
            ),
            entries: Entries::create(
                Entry::create(
                    title: Title::create('Title'),
                    updated: DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2003-12-13T18:30:02Z'
                    ),
                    id: 'some_unique_string'
                )
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><id>some_unique_string</id><title>Scripting News</title><updated>2003-12-13T18:30:02+00:00</updated><link href="/feed" /><link href="/feed" rel="self" /><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name></author><content>/feed</content></entry></feed>
        xml;

        $result = (string) DocumentAtom::create(
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
                    rel: LinkRel::SELF
                )
            ),
            entries: Entries::create(
                Entry::create(
                    title: Title::create('Title'),
                    updated: DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2003-12-13T18:30:02Z'
                    ),
                    content: Content::create('/feed'),
                    id: 'some_unique_string',
                    authors: Authors::create(
                        Author::create('John Doe')
                    )
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

        $result = (string) DocumentAtom::create(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string',
            entries: Entries::create(
                Entry::create(
                    title: Title::create('Title'),
                    updated: DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2003-12-13T18:30:02Z'
                    ),
                    id: 'some_unique_string'
                )
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><id>some_unique_string</id><title>Scripting News</title><updated>2003-12-13T18:30:02+00:00</updated><author><name>John Doe</name></author><author><name>Jane Doe</name></author><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><content>Hello, World!</content></entry></feed>
        xml;

        $result = (string) DocumentAtom::create(
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            id: 'some_unique_string',
            authors: Authors::create(
                Author::create('John Doe'),
                Author::create('Jane Doe')
            ),
            entries: Entries::create(
                Entry::create(
                    title: Title::create('Title'),
                    updated: DateTime::createFromFormat(
                        DateTime::ATOM,
                        '2003-12-13T18:30:02Z'
                    ),
                    id: 'some_unique_string',
                    content: Content::create('Hello, World!')
                )
            )
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = <<<xml
        <?xml version="1.0" ?>
        <feed xmlns="http://www.w3.org/2005/Atom"><id>some_unique_string</id><title>Scripting News</title><updated>2003-12-13T18:30:02+00:00</updated><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name></author><content>Hello, World!</content></entry><entry><title>Title</title><id>some_unique_string</id><updated>2003-12-13T18:30:02Z</updated><author><name>Jane Doe</name></author><content>Hello, World!</content></entry></feed>
        xml;

        $result = (string) DocumentAtom::create(
            id: 'some_unique_string',
            title: Title::create('Scripting News'),
            updated: DateTime::createFromFormat(
                DateTime::ATOM,
                '2003-12-13T18:30:02Z'
            ),
            entries: Entries::create(
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
            )
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
