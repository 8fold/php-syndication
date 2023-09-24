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

namespace Eightfold\Syndication\Rss;

use Stringable;

use DateTime;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Rss\Enclosure;
use Eightfold\Syndication\Rss\Guid;
use Eightfold\Syndication\Rss\Source;
use Eightfold\Syndication\Rss\Categories;

class Item implements Stringable
{
    private string $link = '';

    private Guid $guid;

    private DateTime $pubDate;

    private string $author = '';

    private Categories $categories;

    private string $comments = '';

    private Enclosure $enclosure;

    private Source $source;

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

    public function withAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function withCategories(Categories $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function withComments(string $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function withEnclosure(Enclosure $enclosure): self
    {
        $this->enclosure = $enclosure;
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

    public function withSource(Source $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function isValid(): bool
    {
        if (
            strlen($this->title) > 0 or
            strlen($this->description) > 0
        ) {
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

        $link = (strlen($this->link) === 0) ? '' : Element::link($this->link);

        $description = (strlen($this->description) === 0)
            ? ''
            : Element::description($this->description);

        $author = (strlen($this->author) === 0)
            ? ''
            : Element::author($this->author);

        $categories = (isset($this->categories)) ? $this->categories : '';

        $comments = (strlen($this->comments) === 0)
            ? ''
            : Element::comments($this->comments);

        $enclosure = (isset($this->enclosure))
            ? $this->enclosure
            : '';

        $guid = (isset($this->guid)) ? $this->guid : '';

        $pubDate = '';
        if (isset($this->pubDate)) {
            $pubDate = Element::pubDate(
                $this->pubDate->format(DateTime::RSS)
            );
        }

        $source = (isset($this->source)) ? $this->source : '';

        return (string) Element::item(
            $title,
            $link,
            $description,
            $author,
            $categories,
            $comments,
            $enclosure,
            $guid,
            $pubDate,
            $source
        );
    }
}
