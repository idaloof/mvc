<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiGameController extends AbstractController
{
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
