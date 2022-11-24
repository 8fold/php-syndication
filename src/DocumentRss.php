<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Document as XMLDocument;
use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\RSS\Document as RSSDocument;

use Eightfold\Syndication\Implementations\DocumentImp;

use Eightfold\Syndication\RSS\Item;
use Eightfold\Syndication\RSS\Category;

class DocumentRss implements Buildable
{
    use DocumentImp;

    const VERSION = '2.0';

    public static function create(
        string $title,
        string $link,
        string $description
    ): self {
        return new self(
            title: $title,
            link: $link,
            description: $description
        );
    }

    final private function __construct(
        readonly private string $title,
        readonly private string $link,
        readonly private string $description
    ) {
    }

    public function items(Item ...$items): self
    {
        $this->items = $items;
        return $this;
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $doc = XMLDocument::create(
            'rss',
            Element::channel(
                Element::title($this->title),
                Element::link($this->link),
                Element::description($this->description),
                ...$this->items
            )
        )->props('version ' . self::VERSION);

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
