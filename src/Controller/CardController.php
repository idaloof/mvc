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
        if ($session->has("cards")) {
            $images = $session->get("cards");
            $card = new Card($images);
        } else {
            $card = new Card();
        }

        $cardImages = $card->getImages();
        $session->set("cards", $cardImages);
        $session->set("count", count($card->getImages()));

        return $this->redirectToRoute('deck_draw');
    }

    /* Deck Draw Route */
    #[Route("/card/deck/draw", name: "deck_draw")]
    public function cardDeckDraw(
        SessionInterface $session
    ): Response {
        $images = $session->get("cards");
        if (count($images) > 0) {
            $card = new Card($images);
            $oneCard = $card->drawOneCard();
            $cardsLeft = count($card->getImages());
            $session->set("cards", $card->getImages());

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

        if ($session->has("cards")) {
            $cards = $session->get("cards");
            $card = new Card($cards);
        } else {
            $card = new Card();
            $cards = $card->getImages();
        }

        if ($number === 0) {
            $data = [];
        }

        if (count($cards) > 0 && $number <= count($cards)) {
            $card = new Card($cards);
            $manyCards = [];
            for ($i = 1; $i <= $number; $i++) {
                $oneCard = $card->drawOneCard();
                $manyCards [] = $oneCard;
            }

            $cardsLeft = count($card->getImages());
            $session->set("cards", $card->getImages());

            $data = [
                'cards' => $manyCards,
                'count' => $cardsLeft,
                'number' => $number
            ];

        } elseif ($number > count($cards)) {
            $count = count($cards);
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
            $deck->updateDeck($session->get('remaining'));
        }

        $allCards = $deck->getImages();
        $drawnCards = [];

        if ($cards === 0 || $players === 0) {
            $data = [];
        }

        if ($players * $cards <= count($allCards)) {
            for ($i = 1; $i <= $players; $i++) {
                $aPlayer = [];
                for ($j = 1; $j <= $cards; $j++) {
                    $oneCard = $deck->drawOneCard();
                    array_push($aPlayer, $oneCard);
                }
                array_push($drawnCards, $aPlayer);
            }

            $session->set('remaining', $deck->getImages());

            $data = [
                'allCards' => $drawnCards,
                'count' => count($deck->getImages()),
                'cards' => $cards,
                'players' => $players
            ];
        } else {
            $max = count($deck->getImages());
            $requested = $players * $cards;
            $data = [
                'message' => "You tried to draw {$requested} cards. There are only {$max} cards left.",
                'count' => count($deck->getImages())
            ];
        }

        return $this->render('card/deal.html.twig', $data);
    }
}
