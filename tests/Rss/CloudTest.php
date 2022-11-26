<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\Cloud;

use Eightfold\Syndication\Rss\Enums\CloudProtocol;

class CloudTest extends TestCase
{
    /**
     * @test
     */
    public function compound(): void
    {
        $expected = '<cloud domain="radio.xmlstoragesystem.com" port="80" path="/RPC2" registerProcedure="xmlStorageSystem.rssPleaseNotify" protocol="xml-rpc" />';

        $result = (string) Cloud::create(
            'radio.xmlstoragesystem.com',
            '80',
            '/RPC2',
            'xmlStorageSystem.rssPleaseNotify',
            CloudProtocol::XMLRPC
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
