<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Guid;
use Eightfold\Syndication\Enclosure;
use Eightfold\Syndication\Source;

class Item implements Buildable
{
    private array $categories = [];

    public static function create(
        string $title         = '',
        string $description   = '',
        ?DateTime $pubDate    = null,
        string $author        = '',
        string $link          = '',
        ?Guid $guid           = null,
        string $comments      = '',
        ?Enclosure $enclosure = null,
        ?Source $source       = null
    ): self {
        return new self(
            $title,
            $description,
            $pubDate,
            $author,
            $link,
            $guid,
            $comments,
            $enclosure,
            $source
        );
    }

    final private function __construct(
        readonly private string $title         = '',
        readonly private string $description   = '',
        readonly private ?DateTime $pubDate    = null,
        readonly private string $author        = '',
        readonly private string $link          = '',
        readonly private ?Guid $guid           = null,
        readonly private string $comments      = '',
        readonly private ?Enclosure $enclosure = null,
        readonly private ?Source $source       = null
    ) {
    }

    public function categories(Category ...$categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $hasTitle = strlen($this->title) > 0;
        $hasDescription = strlen($this->description) > 0;
        if ($hasTitle === false and $hasDescription === false) {
            return '';
        }

        $title = ($hasTitle) ? Element::title($this->title) : '';

        $description = ($hasDescription)
            ? Element::description($this->description)
            : '';

        $pubDate = ($this->pubDate === null)
            ? ''
            : $this->pubDate->format(DateTime::RSS);
        $pubDate = str_replace('+0000', 'GMT', $pubDate);
        if (strlen($pubDate) > 0) {
            $pubDate = Element::pubDate($pubDate);
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
            ...$this->categories
        );
    }
}
