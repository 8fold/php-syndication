<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss;

use Stringable;

use Eightfold\XMLBuilder\Element;

class Cloud implements Stringable
{
    public const XMLRPC   = 'xml-rpc';
    public const SOAP     = 'soap';
    public const HTTPPOST = 'http-post';

    /**
     * @param string $domain The domain name or IP address of the cloud.
     * @param string $port The TCP port that the cloud is running on.
     * @param string $path The location of its responder.
     * @param string $registerProcedure The name of the procedure to call to
     *        request notification.
     * @param string $protocol Is xml-rpc, soap, or
     *        http-post (case-sensitive), indicating which protocol is to be used.
     *
     * @return self
     */
    public static function create(
        string $domain,
        string $port,
        string $path,
        string $registerProcedure,
        string $protocol
    ): self {
        return new self($domain, $port, $path, $registerProcedure, $protocol);
    }

    final private function __construct(
        readonly private string $domain,
        readonly private string $port,
        readonly private string $path,
        readonly private string $registerProcedure,
        readonly private string $protocol
    ) {
    }

    public function __toString(): string
    {
        return (string) Element::cloud()->omitEndTag()->props(
            'domain ' . $this->domain,
            'port ' . $this->port,
            'path ' . $this->path,
            'registerProcedure ' . $this->registerProcedure,
            'protocol ' . $this->protocol
        );
    }
}
