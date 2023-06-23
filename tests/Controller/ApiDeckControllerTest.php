<?php

/**
 * Test class for ApiDeckController
 */


namespace App\Controller;

use App\Controller\ApiDeckController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiDeckControllerTest extends TestCase
{
    /**
     * Verifies that response from api returns data set with 52 cards and first card is ace of spades
     */
    public function testJsonDeckData(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $controller = new ApiDeckController();
        $response = $controller->jsonDeck($session);

        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;
        // var_dump($data);

        $count = count($data);

        $this->assertEquals('52', $count);
        $this->assertEquals('Ace of spades', $data[0]["name"]);
    }
}