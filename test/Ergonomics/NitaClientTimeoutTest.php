<?php

/**
 * Tests des délais d'expiration HTTP de NitaClient -- écrits à la main (NON
 * générés), protégés via .openapi-generator-ignore.
 */

namespace Nita\Sdk\Test\Ergonomics;

use GuzzleHttp\Client;
use Nita\Sdk\NitaClient;
use PHPUnit\Framework\TestCase;

class NitaClientTimeoutTest extends TestCase
{
    /** Appelle une méthode statique privée de NitaClient. */
    private static function callPrivate(string $method, array $args)
    {
        $ref = new \ReflectionMethod(NitaClient::class, $method);
        $ref->setAccessible(true);

        return $ref->invokeArgs(null, $args);
    }

    public function testDelaisParDefaut(): void
    {
        $timeouts = self::callPrivate('timeouts', [[]]);
        $this->assertSame(['timeout' => 30.0, 'connect_timeout' => 10.0], $timeouts);

        /** @var Client $client */
        $client = self::callPrivate('makeSigningClient', ['secret', $timeouts]);
        $this->assertSame(30.0, $client->getConfig('timeout'));
        $this->assertSame(10.0, $client->getConfig('connect_timeout'));
    }

    public function testDelaisSurcharges(): void
    {
        $timeouts = self::callPrivate('timeouts', [['timeoutSeconds' => 5, 'connectTimeoutSeconds' => 2]]);

        /** @var Client $client */
        $client = self::callPrivate('makeSigningClient', [null, $timeouts]);
        $this->assertSame(5.0, $client->getConfig('timeout'));
        $this->assertSame(2.0, $client->getConfig('connect_timeout'));
    }

    public function testDelaiInvalideRefuse(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        self::callPrivate('timeouts', [['timeoutSeconds' => 0]]);
    }

    public function testAuthentificationSoumiseAuDelai(): void
    {
        // Port local fermé : la connexion échoue vite, l'essentiel est que postAuth
        // accepte et transmet les délais (pas d'attente infinie possible).
        $this->expectException(\RuntimeException::class);
        self::callPrivate('postAuth', [
            'http://127.0.0.1:9', '/api/authenticate', 'cle', null, ['username' => 'u', 'password' => 'p'],
            ['timeout' => 2.0, 'connect_timeout' => 1.0],
        ]);
    }
}
