<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @SuppressWarnings(PHPMD)
 */

class CardControllerTest extends WebTestCase
{
    public function testHtmlContentCardRoute(): void
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', "/card");

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Card');
    }

    public function testHtmlContentCardDeckRoute(): void
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', "/card/deck");

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Deck');
    }
}