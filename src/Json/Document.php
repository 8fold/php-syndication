<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Json;

use StdClass;
use Stringable;
use JsonSerializable;

use Eightfold\Syndication\Json\Items;
use Eightfold\Syndication\Json\Authors;
use Eightfold\Syndication\Json\Hubs;

use Eightfold\Syndication\Json\CustomObjects;
use Eightfold\Syndication\Json\CustomObject;

class Document implements JsonSerializable
{
    private const VERSION = 'https://jsonfeed.org/version/1.1';

    private string|Stringable $description = '';

    private string|Stringable $userComment = '';

    private string|Stringable $nextUrl = '';

    private string|Stringable $icon = '';

    private string|Stringable $favicon = '';

    private Authors $authors;

    private string|Stringable $language = '';

    private bool $isExpired = false;

    private Hubs $hubs;

    private CustomObjects $customObjects;

    public static function create(
        string|Stringable $title,
        Items $items,
        string|Stringable $homePageUrl = '',
        string|Stringable $feedUrl = ''
    ): self {
        return new self(
            $title,
            $items,
            $homePageUrl,
            $feedUrl
        );
    }

    final private function __construct(
        readonly private string|Stringable $title,
        readonly private Items $items,
        readonly private string|Stringable $homePageUrl = '',
        readonly private string|Stringable $feedUrl = ''
    ) {
    }

    public function withDescription(string|Stringable $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function withUserComment(string|Stringable $userComment): self
    {
        $this->userComment = $userComment;
        return $this;
    }

    public function withNextUrl(string|Stringable $nextUrl): self
    {
        $this->nextUrl = $nextUrl;
        return $this;
    }

    public function withIcon(string|Stringable $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function withFavicon(string|Stringable $favicon): self
    {
        $this->favicon = $favicon;
        return $this;
    }

    public function withAuthors(Authors $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    public function withLanguage(string|Stringable $language): self
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

    public function withExtensions(CustomObjects $customObjects): self
    {
        return $this->withCustomObjects($customObjects);
    }

    /** JsonSerializable **/
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

        if (isset($this->authors)) {
            $obj->authors = $this->authors;
        }

        if (strlen($this->language) > 0) {
            $obj->language = $this->language;
        }

        if ($this->isExpired) {
            $obj->expired = $this->isExpired;
        }

        if (isset($this->hubs)) {
            $obj->hubs = $this->hubs;
        }

        $obj->items = $this->items;

        if (isset($this->customObjects)) {
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
