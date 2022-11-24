<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

// use Stringable;
use DateTime;
//
// use Eightfold\XMLBuilder\Contracts\Buildable;
//
// use Eightfold\XMLBuilder\Document as XMLDocument;
// use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\RSS\Document as RSSDocument;

use Eightfold\Syndication\Atom\Document as AtomDocument;
use Eightfold\Syndication\Atom\Title as AtomTitle;
use Eightfold\Syndication\Atom\Authors as AtomAuthors;
use Eightfold\Syndication\Atom\Links as AtomLinks;
use Eightfold\Syndication\Atom\TextElement as AtomTextElement;

use Eightfold\Syndication\JSON\Document as JSONDocument;
use Eightfold\Syndication\JSON\Items as JSONItems;

class Document
{
    /**
     * @var Item[]
     */
//     private array $items = [];
//
//     private string $xmlVersion = '1.0';
//
//     private string $xmlEncoding = '';
//
//     private string|bool $xmlStandalone = '';

    public static function rss(
        string $title,
        string $link,
        string $description
    ): RSSDocument {
        return RSSDocument::create(
            title: $title,
            link: $link,
            description: $description
        );
    }

    public static function atom(
        AtomTitle $title,
        DateTime $updated,
        string $id,
        ?AtomAuthors $authors = null,
        ?AtomLinks $links = null
    ): AtomDocument {
        return AtomDocument::create(
            title: $title,
            updated: $updated,
            id: $id,
            authors: $authors,
            links: $links
        );
    }

    public static function json(
        string $title,
        JSONItems $items,
        string $homePageUrl = '',
        string $feedUrl = ''
    ): JSONDocument {
        return JSONDocument::create($title, $items, $homePageUrl, $feedUrl);
    }

    // final private function __construct(
    //     readonly private string $title,
    //     readonly private string $link,
    //     readonly private string $description,
    //     readonly private ?DateTime $updated = null
    // ) {
    // }

    // public function items(Item ...$items): self
    // {
    //     $this->items = $items;
    //     return $this;
    // }

    // public function xmlDeclaration(
    //     string|float|int $version = '1.0',
    //     string $encoding = 'UTF-8',
    //     bool $standalone = true
    // ): self {
    //     return $this;
    // }

//     public function build(): string
//     {
//         return strval($this);
//     }
//
//     public function __toString(): string
//     {
//         $doc = XMLDocument::create(
//             'rss',
//             Element::channel(
//                 Element::title($this->title),
//                 Element::link($this->link),
//                 Element::description($this->description),
//                 ...$this->items
//             )
//         )->props('version 2.0');
//
//         $doc = $doc->setVersion($this->xmlVersion);
//
//         if (strlen($this->xmlEncoding) > 0) {
//             $doc = $doc->setEncoding($this->xmlEncoding);
//
//         } else {
//             $doc = $doc->removeEncoding();
//
//         }
//
//         if (is_bool($this->xmlStandalone)) {
//             $doc = $doc->setStandalone($this->xmlStandalone);
//
//         } else {
//             $doc = $doc->removeStandalone();
//
//         }
//
//         return (string) $doc;
//     }
}
