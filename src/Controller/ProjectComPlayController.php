<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This controller and its route is redirected to when human player
 * has folded early in the game and com players keep playing.
 * Mainly to avoid too many redirects.
 */

class ProjectComPlayController extends AbstractController
{
    /* Project Com Play Route */
    #[Route('proj/complay', name:'proj_complay')]
    public function projComPlay(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $communityCards = $game->getCommunityCards();

        $count = count($communityCards);

        $community = [];

        if ($count === 0) {
            $game->setFlopAndGetImages();
            $game->setNextStage();
            $game->setTurnAndGetImages();
            $game->setNextStage();
            $community = $game->setTurnAndGetImages();
            $game->getAndSetBestHands();
        } elseif ($count === 3) {
            $game->setNextStage();
            $game->setTurnAndGetImages();
            $game->setNextStage();
            $community = $game->setTurnAndGetImages();
            $game->getAndSetBestHands();
        } elseif ($count === 4) {
            $game->setNextStage();
            $community = $game->setTurnAndGetImages();
            $game->getAndSetBestHands();
        }

        $session->set('communityImages', $community);

        return $this->redirectToRoute('proj_winner_init');
    }
}
