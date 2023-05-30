<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectBuyInController extends AbstractController
{
    /* Proj Post Route */
    #[Route("/proj/post", name: "proj_post", methods: ['POST'])]
    public function projPostWallet(
        SessionInterface $session,
        Request $request
    ): Response {
        $wallet = $request->request->get('wallet');

        $session->set('wallet', $wallet);

        return $this->redirectToRoute('proj_buy_in');
    }

    /* Proj Buy-in Route */
    #[Route("/proj/buy-in", name: "proj_buy_in")]
    public function projBuyIn(
        SessionInterface $session
    ): Response {
        if ($session->has('wallet')) {
            $wallet = $session->get('wallet');

            return $this->render('proj/buy-in.html.twig', ['wallet' => $wallet]);
        }

        return $this->redirectToRoute('proj');
    }
}
