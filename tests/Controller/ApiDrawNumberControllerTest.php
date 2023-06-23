<?php

/**
 * Test class for ApiDrawNumberController
 */

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * @SuppressWarnings(PHPMD)
 */

class ApiDrawNumberControllerTest extends TestCase
{
    public function testJsonDeckDrawNumberData(): void
    {
        $session = new Session(new MockArraySessionStorage());

        $request = Request::create(
            '/api/draw/',
            'POST',
            ['draw_count' => 3]
        );

        $controller = new ApiDrawNumberController();
        $response = $controller->jsonDeckDrawNumber($session, $request);
        $response = $controller->jsonDeckDrawNumber($session, $request);

        $this->assertEquals(200, $response->getStatusCode());
        
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $count = count($data);

        $this->assertEquals('2', $count);
        $this->assertArrayHasKey('drawnCards', $data);
        $this->assertEquals(3, count($data["drawnCards"]));
    }
}