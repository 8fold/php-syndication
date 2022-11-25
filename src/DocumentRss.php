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

use Eightfold\Syndication\RSS\Items;

class DocumentRss implements Buildable
{
    use DocumentImp;

    const VERSION = '2.0';

    private string $language = '';

    private ?DateTime $pubDate = null;

    private ?DateTime $lastBuildDate = null;

    private string $docs = '';

    private string $generator = '';

    private string $managingEditor = '';

    private string $webMaster = '';

    public static function create(
        string $title,
        string $link,
        string $description,
        Items $items
    ): self {
        return new self(
            title: $title,
            link: $link,
            description: $description,
            items: $items
        );
    }

    final private function __construct(
        readonly private string $title,
        readonly private string $link,
        readonly private string $description,
        readonly private Items $items
    ) {
    }

    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withPubDate(DateTime $pubDate): self
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function withLastBuildDate(DateTime $lastBuildDate): self
    {
        $this->lastBuildDate = $lastBuildDate;
        return $this;
    }

    public function withDocs(string $url): self
    {
        $this->docs = $url;
        return $this;
    }

    public function withGenerator(string $name): self
    {
        $this->generator = $name;
        return $this;
    }

    public function withManagingEditor(string $email): self
    {
        $this->managingEditor = $email;
        return $this;
    }

    public function withWebMaster(string $email): self
    {
        $this->webMaster = $email;
        return $this;
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $language = '';
        if (strlen($this->language) > 0) {
            $language = Element::language($this->language);
        }

        $pubDate = '';
        if ($this->pubDate !== null) {
            $pubDate = Element::pubDate(
                $this->pubDate->format(DateTime::RSS)
            );
        }

        $lastBuildDate = '';
        if ($this->lastBuildDate !== null) {
            $lastBuildDate = Element::lastBuildDate(
                $this->lastBuildDate->format(DateTime::RSS)
            );
        }

        $docs = '';
        if (strlen($this->docs) > 0) {
            $docs = Element::docs($this->docs);
        }

        $generator = '';
        if (strlen($this->generator) > 0) {
            $generator = Element::generator($this->generator);
        }

        $managingEditor = '';
        if (strlen($this->managingEditor) > 0) {
            $managingEditor = Element::managingEditor($this->managingEditor);
        }

        $webMaster = '';
        if (strlen($this->webMaster) > 0) {
            $webMaster = Element::webMaster($this->webMaster);
        }

        $doc = XMLDocument::create(
            'rss',
            Element::channel(
                Element::title($this->title),
                Element::link($this->link),
                Element::description($this->description),
                $language,
                $pubDate,
                $lastBuildDate,
                $docs,
                $generator,
                $managingEditor,
                $webMaster,
                $this->items
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
