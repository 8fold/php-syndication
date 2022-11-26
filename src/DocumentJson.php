<?php
declare(strict_types=1);

namespace Eightfold\Syndication;

use StdClass;
use JsonSerializable;

use Eightfold\Syndication\Json\Items;
use Eightfold\Syndication\Json\Authors;
use Eightfold\Syndication\Json\Hubs;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

class DocumentJson implements JsonSerializable
{
    private const VERSION = 'https://jsonfeed.org/version/1.1';

    private string $description = '';

    private string $userComment = '';

    private string $nextUrl = '';

    private string $icon = '';

    private string $favicon = '';

    private ?Authors $authors = null;

    private string $language = '';

    private bool $isExpired = false;

    private ?Hubs $hubs = null;

    private ?CustomObjects $customObjects = null;

    public static function create(
        string $title,
        Items $items,
        string $homePageUrl = '',
        string $feedUrl = ''
    ): self {
        return new self(
            $title,
            $items,
            $homePageUrl,
            $feedUrl
        );
    }

    final private function __construct(
        readonly private string $title,
        readonly private Items $items,
        readonly private string $homePageUrl = '',
        readonly private string $feedUrl = ''
    ) {
    }

    public function withDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function withUserComment(string $userComment): self
    {
        $this->userComment = $userComment;
        return $this;
    }

    public function withNextUrl(string $nextUrl): self
    {
        $this->nextUrl = $nextUrl;
        return $this;
    }

    public function withIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function withFavicon(string $favicon): self
    {
        $this->favicon = $favicon;
        return $this;
    }

    public function withAuthors(Authors $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function isExpired(): self
    {
        $this->isExpired = true;
        return $this;
    }

    public function withHubs(Hubs $hubs): self
    {
        $this->hubs = $hubs;
        return $this;
    }

    public function withCustomObjects(CustomObjects $customObjects): self
    {
        $this->customObjects = $customObjects;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $obj          = new StdClass();
        $obj->version = self::VERSION;
        $obj->title   = $this->title;

        if (strlen($this->homePageUrl) > 0) {
            $obj->home_page_url = $this->homePageUrl;
        }

        if (strlen($this->feedUrl) > 0) {
            $obj->feed_url = $this->feedUrl;
        }

        if (strlen($this->description) > 0) {
            $obj->description = $this->description;
        }

        if (strlen($this->userComment) > 0) {
            $obj->user_comment = $this->userComment;
        }

        if (strlen($this->nextUrl) > 0) {
            $obj->next_url = $this->nextUrl;
        }

        if (strlen($this->icon) > 0) {
            $obj->icon = $this->icon;
        }

        if (strlen($this->favicon) > 0) {
            $obj->favicon = $this->favicon;
        }

        if ($this->authors !== null) {
            $obj->authors = $this->authors;
        }

        if (strlen($this->language) > 0) {
            $obj->language = $this->language;
        }

        if ($this->isExpired) {
            $obj->expired = $this->isExpired;
        }

        if ($this->hubs !== null) {
            $obj->hubs = $this->hubs;
        }

        $obj->items = $this->items;

        if ($this->customObjects !== null) {
            foreach ($this->customObjects as $customObject) {
                if (is_a($customObject, CustomObject::class)) {
                    $name = $customObject->name();
                    $obj->{$name} = $customObject->object();
                }
            }
        }

        return $obj;
    }
}
