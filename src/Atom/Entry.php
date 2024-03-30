<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;

use DateTime;

// use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Content;
use Eightfold\Syndication\Atom\Summary;
use Eightfold\Syndication\Atom\Rights;
use Eightfold\Syndication\Atom\Subtitle;

use Eightfold\Syndication\Atom\Links;
use Eightfold\Syndication\Atom\Link;

use Eightfold\Syndication\Atom\Categories;

class Entry implements Stringable
{
    private Categories $categories;

    private Contributors $contributors;

    private DateTime $published;

    private Rights $rights;

    private Subtitle $subtitle;

    public static function create(
        Title $title,
        DateTime $updated,
        string $id,
        ?Authors $authors = null,
        ?Content $content = null,
        ?Links $links = null,
        ?Summary $summary = null
    ): self {
        return new self(
            title: $title,
            updated: $updated,
            id: $id,
            authors: $authors,
            content: $content,
            links: $links,
            summary: $summary
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

        if ($this->links !== null) {
            foreach ($this->links as $link) {
                if (
                    is_object($link) and
                    is_a($link, Link::class) and
                    $link->isAlternate()
                ) {
                    return true;
                }
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
        if (isset($this->authors)) {
            $authors = $this->authors;
        }

        $content = '';
        if (isset($this->content)) {
            $content = $this->content;
        }

        $links = '';
        if (isset($this->links)) {
            $links = $this->links;
        }

        $summary = '';
        if (isset($this->summary)) {
            $summary = $this->summary;
        }

        $categories = '';
        if (isset($this->categories)) {
            $categories = $this->categories;
        }

        $contributors = '';
        if (isset($this->contributors)) {
            $contributors = $this->contributors;
        }

        $published = '';
        if (isset($this->published)) {
            $published = Element::published(
                $this->published->format(DateTime::ATOM)
            );
        }

        $rights = '';
        if (isset($this->rights)) {
            $rights = $this->rights;
        }

        $subtitle = '';
        if (isset($this->subtitle)) {
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
