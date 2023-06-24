<?php

namespace App\Controller;

use App\Texas\TexasGame;
use App\Texas\FlashBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectPagesController extends AbstractController
{
    /* Proj Landing Route */
    #[Route("/proj", name: "proj")]
    public function proj(
        SessionInterface $session,
        FlashBag $flashBag
    ): Response {
        $goToRoute = ('proj_add_flash');

        $gameOn = false;

        if ($session->has('game')) {
            /**
             * @var TexasGame $game
             */
            $game = $session->get('game');

            $goToRoute = $session->get('back-route');

            if ($game->isGameReadyForNextStage()) {
                $goToRoute = $session->get('forward-route');
            }

            $gameOn = true;
        }

        if (!$gameOn && !$session->has('flashBag')) {
            $session->set('flashBag', $flashBag);
            $this->redirectToRoute('proj_add_flash');
        }

        /**
         * @var FlashBag $flashBag
         */
        $flashBag = $session->get('flashBag');

        /**
         * @var FlashBag $flashBagReserve
         */
        $flashBagReserve = new FlashBag();

        $session->set('flashBag', $flashBagReserve);

        return $this->render('proj/proj.html.twig', [
            'resetUrl' => $this->generateUrl('proj_reset_database'),
            'currentGameUrl' => $this->generateUrl($goToRoute),
            'flashBag' => $flashBag
        ]);
    }

    /* Proj Flash Route */
    #[Route("/proj/add-flash", name: "proj_add_flash")]
    public function projAddFlash(
        SessionInterface $session
    ): Response {

        if ($session->has('flashBag')) {
            $flashBag = $session->get('flashBag');

            $flashBag->add('warning', 'Inget pågående spel.');

            $session->set('flashBag', $flashBag);
        }

        return $this->redirectToRoute('proj');
    }

    /* Proj About Route */
    #[Route("/proj/about", name: "proj_about")]
    public function projAbout(
    ): Response {

        return $this->render('proj/proj-about.html.twig');
    }

    /* Proj Database Route */
    #[Route("/proj/about/database", name: "proj_database")]
    public function projDatabase(
    ): Response {

        return $this->render('proj/proj-database.html.twig');
    }

    /* Proj API Route */
    #[Route("/proj/api", name: "proj_api")]
    public function projApi(
    ): Response {
        $apiUrls = [
            'cardRankUrl' => $this->generateUrl('proj_api_card_rank'),
            'playerDataUrl' => $this->generateUrl('proj_api_player_data'),
            'gameDataUrl' => $this->generateUrl('proj_api_game_data'),
            'messageDataUrl' => $this->generateUrl('proj_api_message_data'),
            'combinationsUrl' => $this->generateUrl('proj_api_combinations'),
        ];

        return $this->render('proj/proj-api.html.twig', $apiUrls);
    }
}
