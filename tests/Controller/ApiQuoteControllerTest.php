<?php

/**
 * Test class for ApiQuoteController
 */

namespace App\Controller;

use PHPUnit\Framework\TestCase;

class ApiQuoteControllerTest extends TestCase
{
    /**
     * Verifies that response from api returns correct date
     */
    public function testJsonQuoteDate(): void
    {
        $controller = new ApiQuoteController();
        $response = $controller->jsonQuote();

        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $this->assertEquals(date("Y-m-d"), $data["datum"]);
    }

    /**
     * Verifies that response from api returns a quote
     */
    public function testJsonQuote(): void
    {
        $controller = new ApiQuoteController();
        $response = $controller->jsonQuote();

        $quote = [
            "Muddy water is best cleared by leaving it alone.",
            "We cannot be more sensitive to pleasure without being more sensitive to pain.",
            "Problems that remain persistently insoluble should always be suspected as questions asked in the wrong way.",
            "Try to imagine what it will be like to go to sleep and never wake up... now try to imagine what it was like to wake up having never gone to sleep.",
            "You are an aperture through which the universe is looking at and exploring itself."
        ];

        $content = $response->getContent();
        $data = is_string($content) ? json_decode($content, true) : null;

        $this->assertContains($data["quote"], $quote);
    }
}
