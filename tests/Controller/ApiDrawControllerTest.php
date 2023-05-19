<?php

/**
 * Test class for ApiDrawController
 */

namespace App\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiDrawControllerTest extends TestCase
{
    /**
     * Verifies that response status for DrawController is ok
     */
    public function testApiControllerStatusCode() : void
    {
        $client = new Client([
            'base_uri' => 'https://www.student.bth.se/~mafl22/dbwebb-kurser/mvc/me/report/public/',
            'http_errors' => false
        ]);

        $response = $client->post('api/deck/draw');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testJsonDeckDrawData(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $controller = new ApiDrawController();
        $response = $controller->jsonDeckDraw($session);
        $response = $controller->jsonDeckDraw($session);

        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $count = count($data);

        $this->assertEquals('2', $count);
        $this->assertArrayHasKey('drawnCard', $data);
    }
}