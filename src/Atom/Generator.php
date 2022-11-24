<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class Geneator implements Buildable
{
    public static function create(
        string $content,
        string $uri = '',
        string $version = ''
    ): self {
        return new self($content, $uri, $version);
    }

    final private function __construct(
        readonly private string $content,
        readonly private string $uri = '',
        readonly private string $version = ''
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $e = Element::generator($this->content);
        if (strlen($this->uri) === 0 and strlen($this->versions) === 0) {
            return (string) $e;
        }

        $props = [];
        if (strlen($this->uri) > 0) {
            $props[] = 'uri ' . $this->uri;
        }

        if (strlen($this->version) > 0) {
            $props[] = 'version ' . $this->version;
        }

        return (string) $e->props(...$props);
    }
}
