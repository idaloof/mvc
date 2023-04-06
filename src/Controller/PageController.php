<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends AbstractController
{
    /* Home Route */
    #[Route("/", name: "/")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /* About Route */
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /* Report Route */
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    /* Lucky Route */
    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $class = [
            "twenty",
            "forty",
            "sixty",
            "eighty",
            "hundred",
            "hundredtwenty",
            "hundredforty",
            "hundredsixty",
            "hundredeighty",
            "twohundred",
            "twohundredtwenty",
            "twohundredforty",
            "twohundredsixty",
            "lose"
        ];

        $index = random_int(0, count($class)-1);

        $data = [
            'class' => $class[$index]
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/api", name: 'api')]
    public function api(): Response
    {
        $data = [
            'quoteUrl' => $this->generateUrl('api_quote'),
            'deckUrl' => $this->generateUrl('api_deck'),
            'shuffleUrl' => $this->generateUrl('api_deck_shuffle'),
            'drawUrl' => $this->generateUrl('api_draw'),
            'drawNumberUrl' => $this->generateUrl('api_draw_number', ['number' => 1])
        ];
        return $this->render('api.html.twig', $data);
    }
}
