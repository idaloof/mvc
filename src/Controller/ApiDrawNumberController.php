<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiDrawNumberController extends AbstractController
{
    #[Route("/api/deck/draw/number", name: 'api_draw_number', methods: ['POST'])]
    public function jsonDeckDrawNumber(
        SessionInterface $session,
        Request $request
    ): JsonResponse|Response {

        $number = $request->request->get('draw_count');

        $deck = $session->has('remainder') && count($session->get('remainder')->getDeckImages()) > 0
            ? $session->get('remainder')
            : new Deck();

        $drawnCards = [];

        for ($i = 1; $i <= $number; $i++) {
            $oneCard = $deck->drawOneCard();
            array_push($drawnCards, $oneCard);
        }

        $data = [
            'cardsLeft' => count($deck->getDeckImages()),
            'drawnCards' => $drawnCards
        ];

        $session->set('remainder', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
