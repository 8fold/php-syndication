<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss\Enums;

enum CloudProtocol: string
{
    case XMLRPC = 'xml-rpc';
    case SOAP = 'soap';
    case HTTPPOST = 'http-post';
}
