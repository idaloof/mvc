<?php

namespace App\Controller;

use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectRiverInitController extends AbstractController
{
    use MessageTrait;

    /* Proj River Init Route */
    #[Route("/proj/river-init", name: "proj_river_init")]
    public function projRiverInit(
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
        $message = "Rivern på bordet!";

        $this->addMessage($messenger, $message, $doctrine);

        $session->set('game', $game);

        $session->set('communityImages', $communityImages);
        $session->set('game', $game);

        return $this->redirectToRoute('proj_river');
    }
}
