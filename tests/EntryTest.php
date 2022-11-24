<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Atom\Entry;

use DateTime;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Content;
use Eightfold\Syndication\Atom\Summary;
use Eightfold\Syndication\Atom\Authors;
use Eightfold\Syndication\Atom\Author;
//
// use Eightfold\Syndication\Category;
// use Eightfold\Syndication\Guid;
// use Eightfold\Syndication\Enclosure;
// use Eightfold\Syndication\Source;

class EntryTest extends TestCase
{
    /**
     * @test
     */
    public function can_have_published_date(): void
    {
        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><content>Hello, World!</content><summary>Short summary, abstract, or excerpt</summary><published>2003-12-13T18:30:02+00:00</published></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            content: Content::create('Hello, World!'),
            summary: Summary::create('Short summary, abstract, or excerpt')
        )->withPublishedDate(
            DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z')
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_have_summary(): void
    {
        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><content>Hello, World!</content><summary>Short summary, abstract, or excerpt</summary></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            content: Content::create('Hello, World!'),
            summary: Summary::create('Short summary, abstract, or excerpt')
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function must_have_content_if_no_alternate_link_provided(): void
    {
        $expected = '';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z')
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
    /**
     * @test
     */
    public function should_have_author(): void
    {
        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name></author><content>Hello, World!</content></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            authors: Authors::create(
                Author::create('John Doe')
            ),
            content: Content::create('Hello, World!')
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name><uri>https://sample.domain</uri></author><content>Hello, World!</content></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            authors: Authors::create(
                Author::create(
                    name: 'John Doe',
                    uri: 'https://sample.domain'
                )
            ),
            content: Content::create('Hello, World!')
        );

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><author><name>John Doe</name><email>test@sample.domain</email></author><content>Hello, World!</content></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            authors: Authors::create(
                Author::create(
                    name: 'John Doe',
                    email: 'test@sample.domain'
                )
            ),
            content: Content::create('Hello, World!')
        );

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function must_have_required_elements(): void
    {
        $expected = '<entry><title>Atom-Powered Robots Run Amok</title><id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id><updated>2003-12-13T18:30:02Z</updated><content>Hello, World!</content></entry>';

        $result = (string) Entry::create(
            id: 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a',
            title: Title::create('Atom-Powered Robots Run Amok'),
            updated: DateTime::createFromFormat(DateTime::ATOM, '2003-12-13T18:30:02Z'),
            content: Content::create('Hello, World!')
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
