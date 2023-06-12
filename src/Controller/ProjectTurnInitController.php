<?php

namespace App\Controller;

use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectTurnInitController extends AbstractController
{
    use MessageTrait;

    /* Proj Turn Init Route */
    #[Route("/proj/turn-init", name: "proj_turn_init")]
    public function projTurnInit(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        // Community Cards
        $communityImages = $game->setTurnAndGetImages();

        // Hitta bästa handen för alla spelare -> set best hand och best hand name.
        $game->getAndSetBestHands();

        $messenger = "Texas";
        $message = "Turnen på bordet!";

        $this->addMessage($messenger, $message, $doctrine);

        $session->set('game', $game);

        $session->set('communityImages', $communityImages);
        $session->set('game', $game);

        return $this->redirectToRoute('proj_turn');
    }
}
