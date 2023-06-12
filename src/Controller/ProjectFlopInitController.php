<?php

namespace App\Controller;

use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectFlopInitController extends AbstractController
{
    use MessageTrait;

    /* Proj Flop Init Route */
    #[Route("/proj/flop-init", name: "proj_flop_init")]
    public function projFlopInit(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        // Community Cards
        $communityImages = $game->setFlopAndGetImages();

        // Hitta bästa handen för alla spelare -> set best hand och best hand name.
        $game->getAndSetBestHands();

        $messenger = "Texas";
        $message = "Floppen på bordet!";

        $this->addMessage($messenger, $message, $doctrine);

        $session->set('game', $game);

        $session->set('communityImages', $communityImages);
        $session->set('game', $game);

        return $this->redirectToRoute('proj_flop');
    }
}
