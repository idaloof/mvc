<?php

/**
 * Test class for ApiGameController
 */

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ApiGameControllerTest extends TestCase
{
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