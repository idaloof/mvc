<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Texas\CardCombinator;
use App\Texas\HandEvaluator;
use App\Texas\TexasDeck;
use App\Texas\TexasGame;
use App\Texas\TexasPlayer;
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

            $roundWinner = "";
            $winnerCardNames = [];
            $roundWinnerHandName = [];

            if ($gameData->getRoundWinner()) {
                $roundWinner = $gameData->getRoundWinner()->getName();
                $roundWinnerHandName = $gameData->getRoundWinner()->getHand()->getBestHandName();
                $winnerCardObjects = $gameData->getRoundWinnerHand();
                $winnerCardNames = [];

                foreach ($winnerCardObjects as $card) {
                    $winnerCardNames[] = $card->getCardName();
                }
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

    /* Proj API Message Data Route */
    #[Route("/proj/api/message-data", name: "proj_api_message_data", methods: ['POST'])]
    public function projApiMessageData(
        SessionInterface $session,
        Request $request,
        MessagesRepository $repo
    ): JsonResponse {
        $nrOfMessages = intval($request->request->get('messages'));

        $data = [
            'notis' => "Inget spel startat."
        ];

        if ($session->has('game')) {
            $data = $repo->findLatestMessages($nrOfMessages);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize(
            $data,
            'json',
            ['json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE]
        );

        return new JsonResponse($data, 200, [], true);
    }

    /* Proj API Combinations Route */
    #[Route("/proj/api/combinations", name: "proj_api_combinations")]
    public function projApiCombinations(
        SessionInterface $session,
        CardCombinator $combinator,
        TexasDeck $deck,
        HandEvaluator $evaluator
    ): JsonResponse {
        $deck->shuffleDeck();
        $cards = $deck->drawMany(7);

        $fromCommunity = false;

        if ($session->has('game')) {
            /**
             * @var TexasGame $game
             */
            $game = $session->get('game');

            $nrOfCommunityCards = count($game->getCommunityCards());

            if ($nrOfCommunityCards === 5 && $game->setGameData()->getGameStage() === "river") {
                /**
                 * @var TexasPlayer $player
                 */

                $player = $game->getHuman();
                $cards = $game->getCommunityCards();
                foreach ($player->getHand()->getHoleCards() as $card) {
                    $cards[] = $card;
                }
                $fromCommunity = true;
            }
        }

        $randomCardNames = [];

        foreach ($cards as $card) {
            $randomCardNames[] = $card->getCardName();
        }

        $combinations = $combinator->setAndGetCombinations($cards);

        $evalCombos = $evaluator->evaluateManyHands($combinations);

        //$handData[] = [$handPoints, $handName, $hand];

        $nrOfCombos = count($combinations);

        $combosCardNames = [];

        for ($i = 0; $i < $nrOfCombos; $i++) {
            $singleCombo = $evalCombos[$i];
            $singleComboNames = [];
            foreach ($singleCombo[2] as $card) {
                $singleComboNames[] = $card->getCardName();
            }

            $combosCardNames["Kombo " . ((int)$i+1)] = $singleComboNames;
            $combosCardNames["Kombo " . ((int)$i+1)]["Pokerhand"] = $singleCombo[1];
        }

        $inData = [
            'random7Cards' => $randomCardNames,
            'numberOfCombos' => $nrOfCombos,
            'combinations' => $combosCardNames
        ];

        if ($fromCommunity) {
            $inData = [
             'fromGame' => $randomCardNames,
             'numberOfCombos' => $nrOfCombos,
             'combinations' => $combosCardNames
            ];
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize(
            $inData,
            'json',
            ['json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE]
        );

        return new JsonResponse($data, 200, [], true);
    }
}
