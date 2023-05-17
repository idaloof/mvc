<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiDeckController extends AbstractController
{
    #[Route("/api/deck", name: 'api_deck', methods: ['GET'])]
    public function jsonDeck(
        SessionInterface $session
    ): JsonResponse {
        $deck = new Deck();

        $session->set('all', $deck);

        $response = new JsonResponse($deck->getDeck());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
