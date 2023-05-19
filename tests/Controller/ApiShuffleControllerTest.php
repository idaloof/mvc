<?php

/**
 * Test class for ApiShuffleController
 */

namespace App\Controller;

use App\Card\Deck;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiShuffleControllerTest extends TestCase
{
    /**
     * Verifies that response status for ShuffleController is ok
     */
    public function testApiControllerStatusCode() : void
    {
        $client = new Client([
            'base_uri' => 'https://www.student.bth.se/~mafl22/dbwebb-kurser/mvc/me/report/public/',
            'http_errors' => false
        ]);

        $response = $client->post('api/deck/shuffle');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Verifies that response from api returns a deck of cards
     */
    public function testJsonShuffle(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $controller = new ApiShuffleController();
        $response = $controller->jsonDeckShuffle($session);
        $response = $controller->jsonDeckShuffle($session);

        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $count = count($data);

        $this->assertEquals('52', $count);

        $deck = new Deck();

        $session->set('all', $deck);

        $response = $controller->jsonDeckShuffle($session);

        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $count = count($data);

        $this->assertEquals('52', $count);
    }
}
