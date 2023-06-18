<?php

namespace App\Controller;

use App\Texas\TexasGame;
use App\Texas\TexasPlayer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectBuyInController extends AbstractController
{
    /* Proj Wallet Post Route */
    #[Route("/proj/wallet-post", name: "proj_wallet_post", methods: ['POST'])]
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

    /* Proj Manage Wallet Route */
    #[Route("/proj/wallet-manage", name: "proj_wallet_manage")]
    public function projWalletManage(
        SessionInterface $session
    ): Response {
        if ($session->has('game')) {
            /**
             * @var TexasGame $game
             */
            $game = $session->get('game');

            $player = $game->getHuman();

            $data = $player->getPlayerData();

            $data['backUrl'] = $this->generateUrl('proj_reset_round');

            if ($game->isGameTied()) {
                $data['backUrl'] = $this->generateUrl('proj_reset_round_tie');
            }

            return $this->render('proj/proj-manage-wallet.html.twig', $data);
        }

        return $this->redirectToRoute('proj');
    }

    /* Proj Fill Wallet Route */
    #[Route("/proj/wallet-fill", name: "proj_wallet_fill")]
    public function projWalletFill(
        SessionInterface $session,
        Request $request
    ): Response {
        if ($session->has('game')) {
            $money = $request->request->get('wallet');

            /**
             * @var TexasGame $game
             */
            $game = $session->get('game');

            /**
             * @var TexasPlayer $player
             */
            $player = $game->getHuman();

            $player->increaseWallet($money);

            return $this->redirectToRoute('proj_wallet_manage');
        }

        return $this->redirectToRoute('proj');
    }

    /* Proj Fill Buy-in Route */
    #[Route("/proj/buyin-fill", name: "proj_buyin_fill")]
    public function projBuyinFill(
        SessionInterface $session,
        Request $request
    ): Response {
        if ($session->has('game')) {
            $money = $request->request->get('buy-in');

            /**
             * @var TexasGame $game
             */
            $game = $session->get('game');

            /**
             * @var TexasPlayer $player
             */
            $player = $game->getHuman();

            $player->increaseBuyIn($money);
            $player->decreaseWallet($money);

            return $this->redirectToRoute('proj_wallet_manage');
        }

        return $this->redirectToRoute('proj');
    }
}
