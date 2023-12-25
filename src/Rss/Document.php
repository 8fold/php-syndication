<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use DateTime;

use Eightfold\XMLBuilder\Document as XMLDocument;
use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Rss\Items;
use Eightfold\Syndication\Rss\Categories;
use Eightfold\Syndication\Rss\Cloud;
use Eightfold\Syndication\Rss\Image;
use Eightfold\Syndication\Rss\TextInput;
use Eightfold\Syndication\Rss\SkipHours;
use Eightfold\Syndication\Rss\SkipDays;

class Document implements Stringable
{
    private const VERSION = '2.0';

    private string $xmlVersion = '1.0';

    private string $xmlEncoding = '';

    private string|bool $xmlStandalone = '';

    private string $language = '';

    private string $copyright = '';

    private string $managingEditor = '';

    private string $webMaster = '';

    private DateTime $pubDate;

    private DateTime $lastBuildDate;

    private Categories $categories;

    private string $generator = '';

    private string $docs = '';

    private Cloud $cloud;

    private string $ttl = '';

    private Image $image;

    private string $rating = '';

    private TextInput $textInput;

    private SkipHours $skipHours;

    private SkipDays $skipDays;

    private string $renderedItems = '';

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

    public function withXmlDeclaration(
        string|float|int $version = '1.0',
        string $encoding = 'UTF-8',
        bool $standalone = true
    ): self {
        $this->xmlVersion = strval($version);
        $this->xmlEncoding = $encoding;
        $this->xmlStandalone = $standalone;
        return $this;
    }

    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withCopyright(string $copyright): self
    {
        $this->copyright = $copyright;
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

    public function withCategories(Categories $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function withGenerator(string $name): self
    {
        $this->generator = $name;
        return $this;
    }

    public function withDocs(string $url): self
    {
        $this->docs = $url;
        return $this;
    }

    public function withCloud(Cloud $cloud): self
    {
        $this->cloud = $cloud;
        return $this;
    }

    public function withTtl(int $ttl): self
    {
        $this->ttl = strval($ttl);
        return $this;
    }

    public function withImage(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function withRating(string $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function withTextInput(TextInput $input): self
    {
        $this->textInput = $input;
        return $this;
    }

    public function withSkipHours(SkipHours $skipHours): self
    {
        $this->skipHours = $skipHours;
        return $this;
    }

    public function withSkipDays(SkipDays $skipDays): self
    {
        $this->skipDays = $skipDays;
        return $this;
    }

    private function renderedItems(): string
    {
        if (strlen($this->renderedItems) === 0) {
            $this->renderedItems = (string) $this->items;
        }
        return $this->renderedItems;
    }

    public function isValid(): bool
    {
        if (strlen($this->renderedItems()) > 0) {
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

        $language = '';
        if (strlen($this->language) > 0) {
            $language = Element::language($this->language);
        }

        $copyright = '';
        if (strlen($this->copyright) > 0) {
            $copyright = Element::copyright($this->copyright);
        }

        $managingEditor = '';
        if (strlen($this->managingEditor) > 0) {
            $managingEditor = Element::managingEditor($this->managingEditor);
        }

        $webMaster = '';
        if (strlen($this->webMaster) > 0) {
            $webMaster = Element::webMaster($this->webMaster);
        }

        $pubDate = '';
        if (isset($this->pubDate)) {
            $pubDate = Element::pubDate(
                $this->pubDate->format(DateTime::RSS)
            );
        }

        $lastBuildDate = '';
        if (isset($this->lastBuildDate)) {
            $lastBuildDate = Element::lastBuildDate(
                $this->lastBuildDate->format(DateTime::RSS)
            );
        }

        $categories = '';
        if (isset($this->categories)) {
            $categories = $this->categories;
        }

        $generator = '';
        if (strlen($this->generator) > 0) {
            $generator = Element::generator($this->generator);
        }

        $docs = '';
        if (strlen($this->docs) > 0) {
            $docs = Element::docs($this->docs);
        }

        $cloud = '';
        if (isset($this->cloud)) {
            $cloud = $this->cloud;
        }

        $ttl = '';
        if (strlen($this->ttl) > 0) {
            $ttl = Element::ttl($this->ttl);
        }

        $image = '';
        if (isset($this->image)) {
            $image = $this->image;
        }

        $rating = '';
        if (strlen($this->rating) > 0) {
            $rating = Element::rating($this->rating);
        }

        $textInput = '';
        if (isset($this->textInput)) {
            $textInput = $this->textInput;
        }

        $skipHours = '';
        if (isset($this->skipHours)) {
            $skipHours = $this->skipHours;
        }

        $skipDays = '';
        if (isset($this->skipDays)) {
            $skipDays = $this->skipDays;
        }

        $doc = XMLDocument::create(
            'rss',
            Element::channel(
                Element::title($this->title),
                Element::link($this->link),
                Element::description($this->description),
                $language,
                $managingEditor,
                $webMaster,
                $pubDate,
                $lastBuildDate,
                $categories,
                $generator,
                $docs,
                $cloud,
                $image,
                $rating,
                $textInput,
                $skipHours,
                $skipDays,
                $this->renderedItems()
            )
        )->props('version ' . self::VERSION);

        $doc = $doc->withVersion($this->xmlVersion);

        if (strlen($this->xmlEncoding) > 0) {
            $doc = $doc->withEncoding($this->xmlEncoding);

        } else {
            $doc = $doc->removeEncoding();

        }

        if (is_bool($this->xmlStandalone)) {
            $doc = $doc->withStandalone($this->xmlStandalone);

        } else {
            $doc = $doc->removeStandalone();

        }

        return (string) $doc;
    }
}
