<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiTexasGameController extends AbstractController
{
    #[Route("/proj/api-texas", name: 'proj_api_texas')]
    public function jsonDeckShuffle(
        SessionInterface $session
    ): JsonResponse {

        $data = [
            'game notice' => "No game started."
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

            $data["pot"] = $game->getPot();
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
