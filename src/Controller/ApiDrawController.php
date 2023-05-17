<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiDrawController extends AbstractController
{
    #[Route("/api/deck/draw", name: 'api_draw', methods: ['POST'])]
    public function jsonDeckDraw(
        SessionInterface $session
    ): JsonResponse {

        /** @var int $count */
        $count = ($session->has("remainder")) ?
            count($session->get("remainder")->getDeckImages()) : 0;

        /** @var Deck $deck */
        $deck = $session->has('remainder') && $count > 0
                ? $session->get('remainder')
                : new Deck();

        $drawnCard = $deck->drawOneCard();

        $data = [
            'cardsLeft' => count($deck->getDeckImages()),
            'drawnCard' => $drawnCard
        ];

        $session->set('remainder', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
