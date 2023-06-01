<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectPreFlopController extends AbstractController
{
    /* Proj PreFlop Route */
    #[Route("/proj/pre-flop", name: "proj_pre_flop")]
    public function projCreateGame(
        SessionInterface $session,
        MessagesRepository $repository
    ): Response {

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $queuePlayers = $game->getQueuePlayers();

        $queuePlayersData = [];

        foreach ($queuePlayers as $player) {
            $queuePlayersData[] = $player->getPlayerData();
        }

        $messages = $repository->findAll();

        return $this->render('proj/proj-pre-flop.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'messages' => $messages
        ]);
    }
}
