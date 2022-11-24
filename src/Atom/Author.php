<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom;

use Stringable;
use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

class Author implements Buildable
{
    public static function create(
        string $name,
        string $uri = '',
        string $email = ''
    ): self {
        return new self($name, $uri, $email);
    }

    final private function __construct(
        readonly private string $name,
        readonly private string $uri = '',
        readonly private string $email = ''
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        $uri = (strlen($this->uri) === 0) ? '' : Element::uri($this->uri);

        $email = (strlen($this->email) === 0) ? '' : Element::email($this->email);
        return (string) Element::author(
            Element::name($this->name),
            $uri,
            $email
        );
    }
}
