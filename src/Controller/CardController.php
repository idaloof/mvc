<?php

namespace App\Controller;

use App\Card\Card;
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
        $card = new Card();
        $cardImages = $card->getImages();

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
        $session->invalidate();
        $card = new Card();
        $card->shuffleImages();
        $cardImages = $card->getImages();

        $data = [
            'images' => $cardImages
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    /* Deck Draw Init Route */
    #[Route("/card/deck/draw/init", name: "deck_draw_init")]
    public function cardDeckDrawInit(
        SessionInterface $session
    ): Response {
        $cards = $session->has("cards")
            ? $session->get("cards")
            : new Card();

        $session->set("cards", $cards);

        return $this->redirectToRoute('deck_draw');
    }

    /* Deck Draw Route */
    #[Route("/card/deck/draw", name: "deck_draw")]
    public function cardDeckDraw(
        SessionInterface $session
    ): Response {
        $cards = $session->get("cards");
        $cardCount = $cards->countCards();
        if ($cardCount > 0) {
            $oneCard = $cards->drawOneCard();
            $cardsLeft = $cards->countCards();
            $session->set("cards", $cards);

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

        $cards = $session->has("cards")
            ? $session->get("cards")
            : new Card();

        $session->set("cards", $cards);

        $cardCount = $cards->countCards();

        $data = [];

        if ($number === 0) {
            $data = [
                'count' => $cardCount,
                'number' => $number
            ];
        }

        if ($cardCount > 0 && $number <= $cardCount) {
            $manyCards = [];
            for ($i = 1; $i <= $number; $i++) {
                $oneCard = $cards->drawOneCard();
                array_push($manyCards, $oneCard);
            }

            $cardsLeft = $cards->countCards();
            $session->set("cards", $cards);

            $data = [
                'cards' => $manyCards,
                'count' => $cardsLeft,
                'number' => $number
            ];

        } elseif ($number > $cardCount) {
            $count = $cardCount;
            $data = [
                'message' => "You tried to draw {$number} cards. There are only {$count} cards left.",
                'count' => $count
            ];
        }

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

        $deck = new Card();

        if ($session->has('remaining')) {
            $deck = $session->get('remaining');
        }

        $drawnCards = [];

        if ($cards === 0 || $players === 0) {
            $data = [
                'cards' => $cards,
                'players' => $players,
                'count' => $deck->countCards()
            ];

            return $this->render('card/deal.html.twig', $data);
        } elseif ($players * $cards <= $deck->countCards()) {
            for ($i = 1; $i <= $players; $i++) {
                $aPlayer = [];
                for ($j = 1; $j <= $cards; $j++) {
                    $oneCard = $deck->drawOneCard();
                    array_push($aPlayer, $oneCard);
                }
                array_push($drawnCards, $aPlayer);
            }

            $session->set('remaining', $deck);

            $data = [
                'allCards' => $drawnCards,
                'count' => $deck->countCards(),
                'cards' => $cards,
                'players' => $players
            ];

            return $this->render('card/deal.html.twig', $data);
        }

        $max = $deck->countCards();
        $requested = $players * $cards;
        $data = [
            'message' => "You tried to draw {$requested} cards. There are only {$max} cards left.",
            'count' => $max
        ];

        return $this->render('card/deal.html.twig', $data);
    }
}
