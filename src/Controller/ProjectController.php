<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Texas\HandEvaluator;
use Doctrine\Persistence\ManagerRegistry;
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
        ManagerRegistry $doctrine,
        HandEvaluator $handEvaluator
    ): Response {
        // date_default_timezone_set('Europe/Stockholm');
        // $entityManager = $doctrine->getManager();
        // $time = (string) strval(date('H:i'));
        // $messenger = (string) "Host";
        // $newMessage = (string) "Hi, and welcome to this game of Texas Hold'em! Good luck playing!";

        // /**
        //  * @var Messages $message
        //  */

        // $message = new Messages();
        // $message->setCreated($time);
        // $message->setMessenger($messenger);
        // $message->setMessage($newMessage);

        // $entityManager->persist($message);

        // $entityManager->flush();

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
