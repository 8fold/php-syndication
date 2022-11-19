<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Document as XMLDocument;
use Eightfold\XMLBuilder\Element;

class Document implements Buildable
{
    private array $items = [];

    private string $xmlVersion = '1.0';

    private string $xmlEncoding = '';

    private string $xmlStandalone = '';

    public static function rss(
        string $title,
        string $link,
        string $description
    ): self {
        return new self($title, $link, $description);
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

    public function xmlDeclaration(
        string|float|int $version = '1.0',
        string $encoding = 'UTF-8',
        bool $standalone = true
    ): self {
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
        )->props('version 2.0');

        $doc = $doc->setVersion($this->xmlVersion);

        if (strlen($this->xmlEncoding) > 0) {
            $doc = $doc->setEncoding($this->xmlEncoding);

        } else {
            $doc = $doc->removeEncoding();

        }

        if (strlen($this->xmlStandalone) > 0) {
            $doc = $doc->setStandalone($this->xmlStandalone);

        } else {
            $doc = $doc->removeStandalone();

        }

        return (string) $doc;
    }
}
