<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Document as XMLDocument;
use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Implementations\DocumentImp;

use Eightfold\Syndication\Atom\Title;
use Eightfold\Syndication\Atom\Generator;
use Eightfold\Syndication\Atom\Subtitle;

use Eightfold\Syndication\Atom\Entries;
use Eightfold\Syndication\Atom\Rights;
use Eightfold\Syndication\Atom\Authors;
use Eightfold\Syndication\Atom\Links;
use Eightfold\Syndication\Atom\Contributors;
use Eightfold\Syndication\Atom\Categories;

class DocumentAtom implements Buildable
{
    use DocumentImp;

    const VERSION = 'http://www.w3.org/2005/Atom';

    private ?Contributors $contributors = null;

    private ?Categories $categories = null;

    private ?Generatoe $generator = null;

    private string $icon = '';

    private string $logo = '';

    private ?Rights $rights = null;

    private ?Subtitle $subtitle = null;

    public static function create(
        string $id,
        Title $title,
        DateTime $updated,
        Entries $entries,
        ?Authors $authors = null,
        ?Links $links = null
    ): self {
        return new self(
            id: $id,
            title: $title,
            updated: $updated,
            entries: $entries,
            authors: $authors,
            links: $links
        );
    }

    final private function __construct(
        readonly private string $id,
        readonly private Title $title,
        readonly private DateTime $updated,
        readonly private Entries $entries,
        readonly private ?Authors $authors = null,
        readonly private ?Links $links = null
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

    public function withGenerator(Generator $generator): self
    {
        $this->generator = $generator;
        return $this;
    }

    public function withIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function withLogo(string $logo): self
    {
        $this->logo = $logo;
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

    private function passesAuthorCheck(): bool
    {
        if ($this->authors !== null) {
            return true;
        }

        $totalAuthors = 0;
        foreach ($this->entries as $entry) {
            if ($entry->hasAuthors()) {
                $totalAuthors++;
            }
        }
        return count($this->entries) === $totalAuthors;
    }

    private function passesAlternateCheck(): bool
    {
        if ($this->links === null) {
            return true;
        }

        $alternatesFound = 0;
        foreach ($this->links as $link) {
            if ($link->isAlternate()) {
                $alternatesFound++;
            }

            if ($alternatesFound > 1) {
                return false;
            }
        }
        return true;
    }

    private function isValid(): bool
    {
        if (
            $this->passesAuthorCheck() and
            $this->passesAlternateCheck()
        ) {
            return true;
        }
        return false;
    }

    private function isInvalid(): bool
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
        if ($this->authors !== null and $this->authors->count() > 0) {
            $authors = $this->authors;
        }

        $links = '';
        if ($this->links !== null and $this->links->count() > 0) {
            $links = $this->links;
        }

        $contributors = '';
        if (
            $this->contributors !== null and
            $this->contributors->count() > 0
        ) {
            $contributors = $this->contributors;
        }

        $categories = '';
        if (
            $this->categories !== null and
            $this->categories->count() > 0
        ) {
            $categories = $this->categories;
        }

        $generator = '';
        if ($this->generator !== null) {
            $generator = $this->generator;
        }

        $icon = '';
        if (strlen($this->icon) > 0) {
            $icon = Element::icon($this->icon);
        }

        $logo = '';
        if (strlen($this->logo) > 0) {
            $logo = Element::logo($this->logo);
        }

        $rights = '';
        if ($this->rights !== null) {
            $rights = $this->rights;
        }

        $subtitle = '';
        if ($this->subtitle !== null) {
            $subtitle = $this->subtitle;
        }

        $doc = XMLDocument::create(
            'feed',
            $this->title,
            Element::id($this->id),
            Element::updated(
                $this->updated->format(DateTime::ATOM)
            ),
            $links,
            $authors,
            $contributors,
            $categories,
            $generator,
            $icon,
            $logo,
            $rights,
            $subtitle,
            $this->entries
        )->props('xmlns ' . self::VERSION);

        $doc = $doc->setVersion($this->xmlVersion);

        if (strlen($this->xmlEncoding) > 0) {
            $doc = $doc->setEncoding($this->xmlEncoding);

        } else {
            $doc = $doc->removeEncoding();

        }

        if (is_bool($this->xmlStandalone)) {
            $doc = $doc->setStandalone($this->xmlStandalone);

        } else {
            $doc = $doc->removeStandalone();

        }

        return (string) $doc;
    }
}
