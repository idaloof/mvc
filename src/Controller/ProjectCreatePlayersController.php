<?php

namespace App\Controller;

use App\Texas\ComputerCleve;
use App\Texas\ComputerStu;
use App\Texas\TexasPlayer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectCreatePlayersController extends AbstractController
{
    /* Proj Create Players Route */
    #[Route("/proj/create-players", name: "proj_create_players", methods: ['POST'])]
    public function projCreatePlayers(
        SessionInterface $session,
        Request $request
    ): Response {
        $name = $request->request->get('name');
        $buyIn = $request->request->get('buyin');
        $wallet = $session->get('wallet') - $buyIn;

        $human = new TexasPlayer($name, $wallet, $buyIn);
        $stu = new ComputerStu("Stu", $buyIn);
        $cleve = new ComputerCleve("Cleve", $buyIn);

        $players = [$human, $stu, $cleve];

        $session->set('players', $players);
        $session->set('buyin', $buyIn);

        return $this->redirectToRoute('proj_create_game');
    }
}
