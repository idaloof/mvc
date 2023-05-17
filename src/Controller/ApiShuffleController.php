<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiShuffleController extends AbstractController
{
    #[Route("/api/deck/shuffle", name: 'api_deck_shuffle', methods: ['POST'])]
    public function jsonDeckShuffle(
        SessionInterface $session
    ): JsonResponse {

        /**
         * @var Deck The deck of cards
         */
        $deck = $session->has('all')
            ? $session->get('all')
            : new Deck();

        $deck->shuffleDeck();

        $response = new JsonResponse($deck->getDeck());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
