<?php

namespace App\Controller;

use App\Texas\HandEvaluator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /* Proj Route */
    #[Route("/proj", name: "proj")]
    public function projLanding(
        HandEvaluator $handEvaluator
    ): Response {
        $suits = ["H", "D", "C", "H", "H"];
        $values = ["9", "3", "12", "11", "10"];
        $ranks = ["9", "3", "Q", "J", "10"];

        $handData = $handEvaluator->evaluateHand($suits, $values, $ranks);

        $data = [
            "hand" => $handData[0],
            "points" => $handData[1]
        ];

        return $this->render('proj/proj.html.twig', $data);
    }
}
