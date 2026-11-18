<?php

/**
 * Tests de l'URL de base de NitaClient (https obligatoire) -- écrits à la main
 * (NON générés), protégés via .openapi-generator-ignore.
 */

namespace Nita\Sdk\Test\Ergonomics;

use Nita\Sdk\NitaClient;
use PHPUnit\Framework\TestCase;

class NitaClientBaseUrlTest extends TestCase
{
    public function testHttpsEtHttpLocalAcceptes(): void
    {
        foreach ([
            'https://api.exemple.test',
            'HTTPS://api.exemple.test/base',
            'http://localhost:8190',
            'http://127.0.0.1:8190',
            'http://[::1]:8190',
        ] as $url) {
            NitaClient::requireSecureBaseUrl($url);
        }
        $this->addToAssertionCount(1);
    }

    /** @dataProvider urlsRefusees */
    public function testHttpRefuseAilleurs(string $url): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NitaClient::requireSecureBaseUrl($url);
    }

    public function urlsRefusees(): array
    {
        return [
            ['http://api.exemple.test'],
            ['http://localhost.exemple.test'],
            ['http://10.0.0.5:8190'],
            ['ftp://localhost'],
            ['api.exemple.test'],
        ];
    }

    public function testConnectRefuseHttpAvantToutAppel(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('https://');
        NitaClient::connect([
            'baseUrl' => 'http://api.exemple.test',
            'apiKey' => 'k',
            'login' => 'l',
            'password' => 'p',
        ]);
    }
}
