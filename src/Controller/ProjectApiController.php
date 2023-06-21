<?php

namespace App\Controller;

use App\Texas\TexasGame;
use App\Repository\PreFlopRankingsRepository;
// use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProjectApiController extends AbstractController
{
    /* Proj API Card Rank Route */
    #[Route("/proj/api/card-rank", name: "proj_api_card_rank", methods: ['POST'])]
    public function projApiCardRank(
        Request $request,
        PreFlopRankingsRepository $repo
    ): JsonResponse {
        $rank = intval($request->request->get("rank"));

        $cardCombo = $repo->findByRank($rank);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize(
            $cardCombo,
            'json',
            ['json_encode_options' => JSON_PRETTY_PRINT]
        );

        return new JsonResponse($data, 200, [], true);
    }

    /* Proj API Player Data Route */
    #[Route("/proj/api/player-data", name: "proj_api_player_data", methods: ['GET'])]
    public function projApiPlayerData(
        SessionInterface $session
    ): JsonResponse {
        $data = [
            'notis' => "Inget spel startat."
        ];

        if ($session->has('game')) {
            /**
            * @var TexasGame $game
            */
            $game = $session->get('game');

            $players = $game->getQueuePlayers();

            $data = [];

            foreach ($players as $player) {
                $data[] = $player->getPlayerData();
            }
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /* Proj API Game Data Route */
    #[Route("/proj/api/game-data", name: "proj_api_game_data", methods: ['GET'])]
    public function projApiGameData(
        SessionInterface $session
    ): JsonResponse {
        $data = [
            'notis' => "Inget spel startat."
        ];

        if ($session->has('game')) {
            /**
            * @var TexasGame $game
            */
            $game = $session->get('game');
            $gameData = $game->setGameData();

            $communityCardObjects = $gameData->getCommunityCards();
            $communityCardNames = [];

            foreach ($communityCardObjects as $card) {
                $communityCardNames[] = $card->getCardName();
            }

            $roundWinner = $gameData->getRoundWinner()->getName();

            $roundWinnerHandName = $gameData->getRoundWinner()->getHand()->getBestHandName();

            $winnerCardObjects = $gameData->getRoundWinnerHand();

            $winnerCardNames = [];

            foreach ($winnerCardObjects as $card) {
                $winnerCardNames[] = $card->getCardName();
            }

            $data = [
                'gameStage' => $gameData->getGameStage(),
                'pot' => $gameData->getPot(),
                'communityCards' => $communityCardNames,
                'roundWinner' => $roundWinner,
                'winnerHand' => $winnerCardNames,
                'winnerHandName' => $roundWinnerHandName
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    /* Proj API Game Data Route */
    #[Route("/proj/api/hand-data", name: "proj_api_hand_data", methods: ['POST'])]
    public function projApiHandData(
        SessionInterface $session
    ): JsonResponse {
        $data = [
            'notis' => "Inget spel startat."
        ];

        if ($session->has('game')) {
            /**
            * @var TexasGame $game
            */
            $game = $session->get('game');
            $gameData = $game->setGameData();

            $communityCardObjects = $gameData->getCommunityCards();
            $communityCardNames = [];

            foreach ($communityCardObjects as $card) {
                $communityCardNames[] = $card->getCardName();
            }

            $roundWinner = $gameData->getRoundWinner()->getName();

            $roundWinnerHandName = $gameData->getRoundWinner()->getHand()->getBestHandName();

            $winnerCardObjects = $gameData->getRoundWinnerHand();

            $winnerCardNames = [];

            foreach ($winnerCardObjects as $card) {
                $winnerCardNames[] = $card->getCardName();
            }

            $data = [
                'gameStage' => $gameData->getGameStage(),
                'pot' => $gameData->getPot(),
                'communityCards' => $communityCardNames,
                'roundWinner' => $roundWinner,
                'winnerHand' => $winnerCardNames,
                'winnerHandName' => $roundWinnerHandName
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }
}
