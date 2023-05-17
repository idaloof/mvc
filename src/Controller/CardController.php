<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /* Card Route */
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /* Deck Route */
    #[Route("/card/deck", name: "deck")]
    public function cardDeck(): Response
    {
        $deck = new Deck();
        $cardImages = $deck->getDeckImages();

        $data = [
            'images' => $cardImages
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /* Deck Shuffle Route */
    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function cardDeckShuffle(
        SessionInterface $session
    ): Response {
        $deck = new Deck();
        $deck->shuffleDeck();
        $cardImages = $deck->getDeckImages();

        $data = [
            'images' => $cardImages
        ];

        $session->set("deck", $deck);

        return $this->render('card/shuffle.html.twig', $data);
    }

    /* Deck Draw Init Route */
    #[Route("/card/deck/draw/init", name: "deck_draw_init")]
    public function cardDeckDrawInit(
        SessionInterface $session
    ): Response {
        $deck = $session->has("deck")
            ? $session->get("deck")
            : new Deck();

        $session->set("deck", $deck);

        return $this->redirectToRoute('deck_draw');
    }

    /* Deck Draw Route */
    #[Route("/card/deck/draw", name: "deck_draw")]
    public function cardDeckDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $cardCount = count($deck->getDeck());
        if ($cardCount > 0) {
            $oneCardInfo = $deck->drawOneCard();
            $oneCard = $oneCardInfo["image"];
            $cardsLeft = count($deck->getDeck());
            $session->set("deck", $deck);

            $data = [
                'image' => $oneCard,
                'count' => $cardsLeft
            ];

            return $this->render('card/draw.html.twig', $data);
        }

        return $this->render('card/draw.html.twig');
    }

    /* Deck Draw Number Route */
    #[Route("/card/deck/draw/{number<\d+>}", name: "deck_draw_number")]
    public function cardDeckDrawNumber(
        int $number,
        SessionInterface $session,
        Request $request
    ): Response {
        if ($request->isMethod('POST')) {
            $number = $request->request->get('draw_count');
            return $this->redirectToRoute('deck_draw_number', ['number' => $number]);
        }

        $deck = $session->has("deck")
            ? $session->get("deck")
            : new Deck();

        $session->set("deck", $deck);

        $data = [];

        try {
            $manyCards = $deck->drawMany($number);
            $data['cards'] = $manyCards;
        } catch (\Exception $e) {
            $data["message"] = $e->getMessage();
        }

        $cardCount = count($deck->getDeck());

        $data = [
            ...$data,
            'count' => $cardCount,
            'number' => $number,
        ];

        return $this->render('card/draw_number.html.twig', $data);
    }

    /* Deck Deal Route */
    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "deck_deal")]
    public function cardDeckDeal(
        int $cards,
        int $players,
        SessionInterface $session,
        Request $request
    ): Response {
        if ($request->isMethod('POST')) {
            $cards = $request->request->get('draw_count');
            $players = $request->request->get('player_count');
            return $this->redirectToRoute('deck_deal', [
                'cards' => $cards,
                'players' => $players
            ]);
        }

        $deck = new Deck();
        $deck->shuffleDeck();

        if ($session->has('deck')) {
            $deck = $session->get('deck');
        }

        $data = [];

        try {
            $drawnCards = $deck->drawManyCardsAndPlayers($cards, $players);

            $data['allCards'] = $drawnCards;
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }

        $cardCount = count($deck->getDeck());

        $session->set('deck', $deck);

        $data = [
            ...$data,
            'count' => $cardCount,
            'cards' => $cards,
            'players' => $players
        ];

        return $this->render('card/deal.html.twig', $data);
    }
}
