<?php

namespace App\Controller;

use App\Repository\PreFlopRankingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /* Proj Route */
    #[Route("/proj", name: "proj")]
    public function card(
        PreFlopRankingsRepository $repository
    ): Response {
        $cardCombo = $repository->findCardRanking('T8', 's')[0];

        $cardRank = $cardCombo->getRank();

        return $this->render('proj/proj.html.twig', ['cardsRank' => $cardRank]);
    }
}
