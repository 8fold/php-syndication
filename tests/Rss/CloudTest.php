<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\Cloud;

class CloudTest extends TestCase
{
    public function test_compound(): void
    {
        // phpcs:disable
        $expected = '<cloud domain="radio.xmlstoragesystem.com" path="/RPC2" port="80" protocol="xml-rpc" registerProcedure="xmlStorageSystem.rssPleaseNotify" />';
        // phpcs:enable

        $result = (string) Cloud::create(
            'radio.xmlstoragesystem.com',
            '80',
            '/RPC2',
            'xmlStorageSystem.rssPleaseNotify',
            Cloud::XMLRPC
        );

        parent::assertSame(
            $expected,
            $result
        );
    }
}
