<?php

/**
 * Test class for ApiDrawController
 */

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiDrawControllerTest extends TestCase
{
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