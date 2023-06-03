<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Texas\TexasGame;
use App\Repository\MessagesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProjectPlayerCallController whose routes are visited
 * when player calls.
 */

class ProjectPlayerCallController extends AbstractController
{
    /* Proj Call Route */
    #[Route('proj/player-call', name:'proj_player_call', methods: ['POST'])]
    public function projPlayerCall(
        SessionInterface $session,
        Request $request
    ): Response
    {
        $callAmount = $request->request->get('call-amount');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $player = $game->playerCalls($callAmount);

        $message = $request->request->get('message');

        $session->set('message', $message);

        $session->set('messenger', $player->getName());

        $session->set('callAmount', $callAmount);

        return $this->redirectToRoute('proj_call_message');
    }

    /* Proj Call Message Route */
    #[Route('proj/call-message', name:'proj_call_message')]
    public function projCallMessage(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        MessagesRepository $repo
    ): Response
    {
        $newMessage = $session->get('message');

        $callAmount = $session->get('callAmount');

        $messenger = $session->get('messenger');

        $entityManager = $doctrine->getManager();

        $message = new Messages();

        date_default_timezone_set('Europe/Stockholm');

        $currentTime = date('H:i');

        $message->setCreated(strval($currentTime));
        $message->setMessenger($messenger);
        $message->setMessage($newMessage . " " . $callAmount);

        $entityManager->persist($message);

        $entityManager->flush();

        $route = "_pre_flop";

        return $this->redirectToRoute('proj' . $route);
    }
}