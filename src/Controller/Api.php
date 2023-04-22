<?php

namespace App\Controller;

use App\Card\Deck;
use DateTime;
use DateTimeZone;
use App\Card\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Api extends AbstractController
{
    #[Route("/api/quote", name: 'api_quote')]
    public function jsonQuote(): JsonResponse
    {
        $quote = [
            "Muddy water is best cleared by leaving it alone.",
            "We cannot be more sensitive to pleasure without being more sensitive to pain.",
            "Problems that remain persistently insoluble should always be suspected as questions asked in the wrong way.",
            "Try to imagine what it will be like to go to sleep and never wake up... now try to imagine what it was like to wake up having never gone to sleep.",
            "You are an aperture through which the universe is looking at and exploring itself."
        ];

        $index = random_int(0, count($quote)-1);

        $date = new DateTime("now", new DateTimeZone('Europe/Stockholm'));

        $data = [
            'quote' => $quote[$index],
            'datum' => date("Y-m-d"),
            'klockslag' => $date->format("H:i:s"),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

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

   #[Route("/api/deck/draw/{number<\d+>}", name: 'api_draw_number', methods: ['POST', 'GET'])]
    public function jsonDeckDrawNumber(
        int $number,
        SessionInterface $session,
        Request $request
    ): JsonResponse|Response {
        if ($request->isMethod('POST')) {
            $number = $request->request->get('draw_count');
            return $this->redirectToRoute('api_draw_number', ['number' => $number]);
        }

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

   #[Route("/api/game", name: 'api_game', methods: ['GET'])]
    public function jsonGame(
        SessionInterface $session
    ): JsonResponse {
        if ($session->has("game")) {
            $game = $session->get('game');

            $standings = $game->getGameStandings();

            $data = [
                "humanCards" => $standings["human"]["cards"],
                "humanPoints" => $standings["human"]["points"],
                "bankCards" => $standings["bank"]["cards"],
                "bankPoints" => $standings["bank"]["points"],
                "isWinnerDecided" => $standings["winner_decided"],
                "winner" => $standings["winner"]
            ];

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $data = [
            "notice" => "No game started yet.",
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
