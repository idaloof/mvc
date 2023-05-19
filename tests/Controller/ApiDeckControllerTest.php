<?php

/**
 * Test class for ApiDeckController
 */

namespace App\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiDeckControllerTest extends TestCase
{
    /**
     * Verifies that response status for DeckController is ok
     */
    public function testApiControllerStatusCode() : void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8888/',
            'http_errors' => false
        ]);

        $response = $client->get('api/deck');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Verifies that response status for DeckController is ok
     */
    public function testJsonDeckData(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $controller = new ApiDeckController();
        $response = $controller->jsonDeck($session);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        // var_dump($data);

        $count = count($data);

        $this->assertEquals('52', $count);
        $this->assertEquals('Ace of spades', $data[0]["name"]);
    }
}