<?php
declare(strict_types=1);

namespace Eightfold\Syndication\RSS;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Element;

use Eightfold\Syndication\Rss\Enums\CloudProtocol;

class Cloud implements Buildable
{
    /**
     * @param string $domain The domain name or IP address of the cloud.
     * @param string $port The TCP port that the cloud is running on.
     * @param string $path The location of its responder.
     * @param string $registerProcedure The name of the procedure to call to
     *        request notification.
     * @param CloudProtocol $protocol Is xml-rpc, soap, or
     *        http-post (case-sensitive), indicating which protocol is to be used.
     *
     * @return self
     */
    public static function create(
        string $domain,
        string $port,
        string $path,
        string $registerProcedure,
        CloudProtocol $protocol
    ): self {
        return new self($domain, $port, $path, $registerProcedure, $protocol);
    }

    final private function __construct(
        readonly private string $domain,
        readonly private string $port,
        readonly private string $path,
        readonly private string $registerProcedure,
        readonly private CloudProtocol $protocol
    ) {
    }

    public function build(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return (string) Element::cloud()->omitEndTag()->props(
            'domain ' . $this->domain,
            'port ' . $this->port,
            'path ' . $this->path,
            'registerProcedure ' . $this->registerProcedure,
            'protocol ' . $this->protocol->value
        );
    }
}
