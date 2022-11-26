<?php
/**
 * php-syndication - Item.php
 *
 * @author Josh Bruce
 *
 * All elements of an item are optional, however at least one of title or
 * description must be present.
 */
declare(strict_types=1);

namespace Eightfold\Syndication\RSS;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\RSS\Enclosure;

use Eightfold\Syndication\RSS\Guid;
use Eightfold\Syndication\RSS\Source;
use Eightfold\Syndication\RSS\Categories;

class Item implements Buildable
{
    private string $link = '';

    private ?Guid $guid = null;

    private ?DateTime $pubDate = null;

    private string $author = '';

    private string $comments = '';

    private ?Enclosure $enclosure = null;

    private ?Source $source = null;

    private ?Categories $categories = null;

    public static function create(
        string $title = '',
        string $description = ''
    ): self {
        return new self($title, $description);
    }

    final private function __construct(
        readonly private string $title = '',
        readonly private string $description = ''
    ) {
    }

    public function withLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function withGuid(Guid $guid): self
    {
        $this->guid = $guid;
        return $this;
    }

    public function withPubDate(DateTime $date): self
    {
        $this->pubDate = $date;
        return $this;
    }

    public function withAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function withComments(string $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function withEclosure(Enclosure $enclosure): self
    {
        $this->enclosure = $enclosure;
        return $this;
    }

    public function withSource(Source $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function withCategories(Categories $categories): sefl
    {
        $this->categories = $categories;
        return $this;
    }

    public function isValid(): bool
    {
        if (strlen($this->title) > 0) {
            return true;
        }

        if (strlen($this->description) > 0) {
            return true;
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

        $title = (strlen($this->title) === 0) ? '' : Element::title($this->title);

        $description = (strlen($this->description) === 0)
            ? ''
            : Element::description($this->description);

        $pubDate = '';
        if ($this->pubDate !== null) {
            $pubDate = Element::pubDate(
                $this->pubDate->format(DateTime::RSS)
            );
        }

        $author = (strlen($this->author) === 0)
            ? ''
            : Element::author($this->author);

        $link = (strlen($this->link) === 0) ? '' : Element::link($this->link);

        $guid = ($this->guid === null) ? '' : $this->guid;

        $comments = (strlen($this->comments) === 0)
            ? ''
            : Element::comments($this->comments);

        $enclosure = ($this->enclosure === null)
            ? ''
            : $this->enclosure;

        $source = ($this->source === null) ? '' : $this->source;

        $categories = ($this->categories === null) ? '' : $this->categories;

        return (string) Element::item(
            $title,
            $description,
            $pubDate,
            $author,
            $link,
            $guid,
            $comments,
            $enclosure,
            $source,
            $categories
        );
    }
}
