<?php

/**
 * Tests de CallbackVerifier -- écrits à la main (NON générés), protégés via
 * .openapi-generator-ignore. Vecteur de test commun aux 7 SDK.
 */

namespace Nita\Sdk\Test\Ergonomics;

use Nita\Sdk\CallbackVerifier;
use Nita\Sdk\NitaCallbackException;
use PHPUnit\Framework\TestCase;

class CallbackVerifierTest extends TestCase
{
    private const SECRET = 's3cret';
    private const TIMESTAMP = 1700000000;
    private const NONCE = 'nonce-0123456789';
    private const BODY = '{"status":"1","transaction_id":"ACHAT1"}';
    private const SIGNATURE = 'f4027a7eedeb961572515d3319ba9d78714689b687a96942f3eb0335abc61ec3';

    private static function verifier(?callable $isNewNonce = null, int $now = self::TIMESTAMP): CallbackVerifier
    {
        return new CallbackVerifier(self::SECRET, $isNewNonce, 300, function () use ($now) {
            return $now;
        });
    }

    private static function headers(array $override = []): array
    {
        return array_merge([
            'X-NT-TIMESTAMP' => (string) self::TIMESTAMP,
            'X-NT-NONCE' => self::NONCE,
            'X-NT-SIGNATURE' => self::SIGNATURE,
        ], $override);
    }

    private function assertRejected(string $message, callable $fn): void
    {
        try {
            $fn();
            $this->fail('NitaCallbackException attendue : ' . $message);
        } catch (NitaCallbackException $e) {
            $this->assertSame($message, $e->getMessage());
        }
    }

    public function testVecteurCommunAccepte(): void
    {
        $this->assertSame(self::SIGNATURE, hash_hmac('sha256', self::TIMESTAMP . "\n" . self::NONCE . "\n" . self::BODY, self::SECRET));

        $payload = self::verifier()->verify(self::BODY, self::headers());

        $this->assertSame('1', $payload['status']);
        $this->assertSame('ACHAT1', $payload['transaction_id']);
    }

    public function testEnTetesCasseQuelconqueEtListes(): void
    {
        $payload = self::verifier()->verify(self::BODY, [
            'x-nt-timestamp' => [(string) self::TIMESTAMP],
            'X-Nt-Nonce' => [self::NONCE, 'ignore'],
            'x-NT-signature' => self::SIGNATURE,
        ]);

        $this->assertSame('1', $payload['status']);
    }

    public function testEnTeteManquantOuVide(): void
    {
        $headers = self::headers();
        unset($headers['X-NT-NONCE']);
        $this->assertRejected('En-tetes de signature manquants', function () use ($headers) {
            self::verifier()->verify(self::BODY, $headers);
        });
        $this->assertRejected('En-tetes de signature manquants', function () {
            self::verifier()->verify(self::BODY, self::headers(['X-NT-SIGNATURE' => '']));
        });
    }

    public function testSecretVide(): void
    {
        $this->expectException(NitaCallbackException::class);
        new CallbackVerifier('');
    }

    public function testHorodatageHorsTolerance(): void
    {
        foreach ([self::TIMESTAMP + 301, self::TIMESTAMP - 301] as $now) {
            $this->assertRejected('Horodatage hors tolerance', function () use ($now) {
                self::verifier(null, $now)->verify(self::BODY, self::headers());
            });
        }
        $this->assertSame('1', self::verifier(null, self::TIMESTAMP + 300)->verify(self::BODY, self::headers())['status']);
        $this->assertRejected('Horodatage hors tolerance', function () {
            self::verifier()->verify(self::BODY, self::headers(['X-NT-TIMESTAMP' => '1700000000.5']));
        });
    }

    public function testSignatureModifiee(): void
    {
        $this->assertRejected('Signature invalide', function () {
            self::verifier()->verify(self::BODY, self::headers(['X-NT-SIGNATURE' => str_repeat('0', 64)]));
        });
    }

    public function testCorpsModifieDUnCaractere(): void
    {
        $this->assertRejected('Signature invalide', function () {
            self::verifier()->verify('{"status":"2","transaction_id":"ACHAT1"}', self::headers());
        });
    }

    public function testRejeu(): void
    {
        $seen = [];
        $ttls = [];
        $store = function (string $nonce, int $ttl) use (&$seen, &$ttls) {
            $ttls[] = $ttl;
            if (isset($seen[$nonce])) {
                return false;
            }
            $seen[$nonce] = true;

            return true;
        };
        $verifier = self::verifier($store);

        $verifier->verify(self::BODY, self::headers());
        $this->assertRejected('Nonce deja utilise (rejeu)', function () use ($verifier) {
            $verifier->verify(self::BODY, self::headers());
        });
        $this->assertSame([600, 600], $ttls);
    }

    public function testStoreNonAppeleSiSignatureInvalide(): void
    {
        $calls = 0;
        $store = function () use (&$calls) {
            $calls++;

            return true;
        };
        $this->assertRejected('Signature invalide', function () use ($store) {
            self::verifier($store)->verify(self::BODY . ' ', self::headers());
        });
        $this->assertSame(0, $calls);
    }

    public function testCorpsNonJsonSigne(): void
    {
        foreach (['pas du json', '[1,2]', '"texte"'] as $body) {
            $signature = hash_hmac('sha256', self::TIMESTAMP . "\n" . self::NONCE . "\n" . $body, self::SECRET);
            $this->assertRejected('Corps JSON invalide', function () use ($body, $signature) {
                self::verifier()->verify($body, self::headers(['X-NT-SIGNATURE' => $signature]));
            });
        }
    }
}
