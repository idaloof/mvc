<?php

namespace App\Controller;

use App\Texas\TexasGame;
use App\Entity\Messages;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectFlopInitController extends AbstractController
{
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

        $entityManager = $doctrine->getManager();

        $message = new Messages();

        date_default_timezone_set('Europe/Stockholm');

        $currentTime = date('H:i');

        $message->setCreated(strval($currentTime));
        $message->setMessenger("Texas");
        $message->setMessage("Floppen på bordet!");

        $entityManager->persist($message);

        $entityManager->flush();

        $session->set('game', $game);

        $session->set('communityImages', $communityImages);
        $session->set('game', $game);

        return $this->redirectToRoute('proj_flop');
    }
}
