<?php

namespace App\Controller;

// use App\Entity\Messages;
use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectResetController extends AbstractController
{
    use MessageTrait;
    /* Proj Reset Stage Route */
    #[Route("/proj/reset-stage", name: "proj_reset_stage")]
    public function projResetStage(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $game->setNextStage();

        $fRoute = $session->get('forward-route');

        $session->set('game', $game);

        return $this->redirectToRoute($fRoute);
    }

    /* Proj Reset Round Route */
    #[Route("/proj/reset-round", name: "proj_reset_round")]
    public function projResetRound(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $winnerData = $game->setNewRound();

        $player = $winnerData[0]->getName();
        $pot = $winnerData[1];

        $messenger = "Texas";
        $aMessage = $player . " vinner potten på " . "$" . $pot;

        $this->addMessage($messenger, $aMessage, $doctrine);

        $messenger = "Texas";
        $aMessage = "Ny runda, blinds ute!";

        $this->addMessage($messenger, $aMessage, $doctrine);

        $session->set('game', $game);

        return $this->redirectToRoute('proj_pre_flop');
    }

    /* Proj Reset Round Tie Game Route */
    #[Route("/proj/reset-round-tie", name: "proj_reset_round_tie")]
    public function projResetRoundTie(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $winnerData = $game->setNewRoundTie();

        $players = $winnerData[0];
        $playerNames = "";

        foreach ($players as $player) {
            $playerNames .= $player->getName() . ", ";
        }

        $pot = $winnerData[1];

        $messenger = "Texas";
        $aMessage = $playerNames . "delar på potten " . "$" . $pot;

        $this->addMessage($messenger, $aMessage, $doctrine);

        $messenger = "Texas";
        $aMessage = "Ny runda, blinds ute!";

        $this->addMessage($messenger, $aMessage, $doctrine);

        $session->set('game', $game);

        return $this->redirectToRoute('proj_pre_flop');
    }
}
