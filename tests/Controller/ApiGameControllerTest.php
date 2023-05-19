<?php

/**
 * Test class for ApiGameController
 */

namespace App\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiGameControllerTest extends TestCase
{
    /**
     * Verifies that response status for GameController is ok
     */
    public function testApiControllerStatusCode() : void
    {
        $client = new Client([
            'base_uri' => 'https://www.student.bth.se/~mafl22/dbwebb-kurser/mvc/me/report/public/',
            'http_errors' => false
        ]);

        $response = $client->get('api/game');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testJsonGameNoStarted(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $controller = new ApiGameController();
        $response = $controller->jsonGame($session);
        $response = $controller->jsonGame($session);

        $this->assertEquals(200, $response->getStatusCode());
        
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $this->assertArrayHasKey('notice', $data);
    }
}