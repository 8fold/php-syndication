<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Content;
use Eightfold\Syndication\Atom\Summary;
use Eightfold\Syndication\Atom\Rights;
use Eightfold\Syndication\Atom\Subtitle;

use Eightfold\Syndication\Atom\Categories;

//
// use Eightfold\Syndication\Guid;
// use Eightfold\Syndication\Enclosure;
// use Eightfold\Syndication\Source;

class Entry implements Buildable
{
    private ?Categories $categories = null;

    private ?Contributors $contributors = null;

    private ?DateTime $published = null;

    private ?Rights $rights = null;

    private ?Subtitle $subtitle = null;

    public static function create(
        Title $title,
        DateTime $updated,
        string $id,
        ?Authors $authors = null,
        ?Content $content = null,
        ?Links $links = null,
        ?Summary $summary = null
//         string $description = '',
//
//         string $author = '',
//
//         ?Guid $guid = null,
//         string $comments = '',
//         ?Enclosure $enclosure = null,
//         ?Source $source = null
    ): self {
        return new self(
            title: $title,
            updated: $updated,
            id: $id,
            authors: $authors,
            content: $content,
            links: $links,
            summary: $summary
            // $description,
            // $author,
            // $guid,
            // $comments,
            // $enclosure,
            // $source
        );
    }

    final private function __construct(
        readonly private Title $title,
        readonly private DateTime $updated,
        readonly private string $id,
        readonly private ?Authors $authors = null,
        readonly private ?Content $content = null,
        readonly private ?Links $links = null,
        readonly private ?Summary $summary = null
        // readonly private string $description = '',
        // readonly private string $author = '',
        // readonly private ?Guid $guid = null,
        // readonly private string $comments = '',
        // readonly private ?Enclosure $enclosure = null,
        // readonly private ?Source $source = null
    ) {
    }

    public function withCategories(Categories $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function withContributors(Contributors $contributors): self
    {
        $this->contributors = $contributors;
        return $this;
    }

    public function withPublishedDate(DateTime $published): self
    {
        $this->published = $published;
        return $this;
    }

    public function withRights(Rights $rights): self
    {
        $this->rights = $rights;
        return $this;
    }

    public function withSubtitle(Subtitle $subtitle): self
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function hasAuthors(): bool
    {
        return $this->authors !== null;
    }

    public function isValid(): bool
    {
        if ($this->content !== null) {
            return true;
        }

        if ($this->content === null and $this->links === null) {
            return false;
        }

        foreach ($this->links as $link) {
            if ($link->isAlternate()) {
                return true;
            }
        }
        return false;
    }

    public function isInvalid(): bool
    {
        return ! $this->isValid();
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        if ($this->isInvalid()) {
            return '';
        }

        $authors = '';
        if ($this->authors !== null) {
            $authors = $this->authors;
        }

        $content = '';
        if ($this->content !== null) {
            $content = $this->content;
        }

        $links = '';
        if ($this->links !== null) {
            $links = $this->links;
        }

        $summary = '';
        if ($this->summary !== null) {
            $summary = $this->summary;
        }

        $categories = '';
        if ($this->categories !== null) {
            $categories = $this->categories;
        }

        $contributors = '';
        if ($this->contributors !== null) {
            $contributors = $this->contributors;
        }

        $published = '';
        if ($this->published !== null) {
            $published = Element::published(
                $this->published->format(DateTime::ATOM)
            );
        }

        $rights = '';
        if ($this->rights !== null) {
            $rights = $this->rights;
        }

        $subtitle = '';
        if ($this->subtitle !== null) {
            $subtitle = $this->subtitle;
        }

        return (string) Element::entry(
            $this->title,
            Element::id($this->id),
            Element::updated(
                str_replace(
                    '+00:00',
                    'Z',
                    $this->updated->format(DateTime::ATOM)
                )
            ),
            $authors,
            $content,
            $links,
            $summary,
            $categories,
            $contributors,
            $published,
            $rights,
            $subtitle
        );
    }
}
