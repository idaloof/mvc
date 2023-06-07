<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectResetController extends AbstractController
{
    /* Proj Reset Stage Route */
    #[Route("/proj/reset-stage", name: "proj_reset_stage")]
    public function projResetStage(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $game->resetForNextStage();

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

        $winnerData = $game->resetForNewRound();

        $entityManager = $doctrine->getManager();

        $player = $winnerData[0]->getName();
        $pot = $winnerData[1];

        date_default_timezone_set('Europe/Stockholm');

        $currentTime = date('H:i');

        $message = new Messages();

        $message->setCreated(strval($currentTime));
        $message->setMessenger("Texas");
        $message->setMessage($player . " vinner potten på " . $pot);

        $entityManager->persist($message);

        $message = new Messages();

        $message->setCreated(strval($currentTime));
        $message->setMessenger("Texas");
        $message->setMessage("Ny runda, blinds ute!");

        $entityManager->persist($message);

        $entityManager->flush();

        $session->set('game', $game);

        return $this->redirectToRoute('proj_pre_flop');
    }
}
