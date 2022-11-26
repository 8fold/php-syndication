<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use DateTime;
use StdClass;
use JsonSerializable;

use Eightfold\Syndication\Json\ContentHtml;
use Eightfold\Syndication\Json\Authors;
use Eightfold\Syndication\Json\Attachments;
use Eightfold\Syndication\Json\CustomObjects;

/**
 * @todo: Test the content_html content_text rules - MUST have one, the other, or both.
 */
class Item implements JsonSerializable
{
    private string|ContentHtml|null $extraContent = null;

    private string $url = '';

    private string $externalUrl = '';

    private string $title = '';

    private string $summary = '';

    private string $image = '';

    private string $bannerImage = '';

    private ?DateTime $datePublished = null;

    private ?DateTime $dateModified = null;

    private ?Authors $authors = null;

    /**
     * @var string[]
     */
    private array $tags = [];

    private string $language = '';

    private ?Attachments $attachments = null;

    private ?CustomObjects $customObjects = null;

    public static function create(
        string $id,
        string|ContentHtml $content
    ): self {
        return new self($id, $content);
    }

    final private function __construct(
        readonly private string $id,
        readonly private string|ContentHtml $content
    ) {
    }

    public function withExtraContent(string|ContentHtml $extraContent): self
    {
        $this->extraContent = $extraContent;
        return $this;
    }

    public function withUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function withExternalUrl(string $externalUrl): self
    {
        $this->externalUrl = $externalUrl;
        return $this;
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function withSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    public function withImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function withBannerImage(string $bannerImage): self
    {
        $this->bannerImage = $bannerImage;
        return $this;
    }

    public function withDatePublished(DateTime $datePublished): self
    {
        $this->datePublished = $datePublished;
        return $this;
    }

    public function withDateModified(DateTime $dateModified): self
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    public function withAuthors(Authros $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    public function withTags(string ...$tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withAttachments(Attachments $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function withCustomObjects(CustomObjects $customObjects): self
    {
        $this->customObjects = $customObjects;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $obj = new StdClass();
        $obj->id = $this->id;

        if (strlen($this->url) > 0) {
            $obj->url = $this->url;
        }

        if (strlen($this->externalUrl) > 0) {
            $obj->external_url = $this->externalUrl;
        }

        if (strlen($this->title) > 0) {
            $obj->title = $this->title;
        }

        if (is_a($this->content, ContentHtml::class)) {
            $obj->content_html = (string) $this->content;

        } else {
            $obj->content_text = $this->content;

        }

        if ($this->extraContent !== null) {
            if (is_a($this->extraContent, ContentHtml::class)) {
                $obj->content_html = (string) $this->extraContent;

            } else {
                $obj->content_text = $this->extraContent;

            }
        }

        if (strlen($this->summary) > 0) {
            $obj->summary = $this->summary;
        }

        if (strlen($this->image) > 0) {
            $obj->image = $this->image;
        }

        if (strlen($this->bannerImage) > 0) {
            $obj->banner_image = $this->bannerImage;
        }

        if ($this->datePublished !== null) {
            $obj->date_published = $this->datePublished->format(DateTime::ATOM);
        }

        if ($this->dateModified !== null) {
            $obj->date_modified = $this->dateModified->format(DateTime::ATOM);
        }

        if ($this->authors !== null) {
            $obj->authors = $this->authors;
        }

        if (count($this->tags) > 0) {
            $obj->tags = $this->tags;
        }

        if (strlen($this->language) > 0) {
            $obj->language = $this->language;
        }

        if ($this->attachments !== null) {
            $obj->attachments = $this->attachments;
        }

        if ($this->customObjects !== null) {
            foreach ($this->customObjects as $customObject) {
                $name = $customObject->name();
                $obj->{$name} = $customObject->object();
            }
        }

        return $obj;
    }
}
