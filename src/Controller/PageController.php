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
            'drawNumberUrl' => $this->generateUrl('api_draw_number', ['number' => 1]),
            'gameUrl' => $this->generateUrl('api_game'),
            'booksUrl' => $this->generateUrl('api_library_books'),
            'bookUrl' => $this->generateUrl('api_library_book_isbn', ['isbn' => 9780446569903])
        ];

        return $this->render('api.html.twig', $data);
    }

    #[Route("/library", name: 'library')]
    public function library(): Response
    {
        $data = [
            'createBookUrl' => $this->generateUrl('book_create'),
            'showOneBookUrl' => $this->generateUrl('book_by_id', ['id' => 1]),
            'showAllBooksUrl' => $this->generateUrl('book_read_many'),
            'updateBookUrl' => $this->generateUrl('book_update', ['anId' => 1]),
            'deleteBookUrl' => $this->generateUrl('book_delete', ['anId' => 1]),
            'resetLibraryUrl' => $this->generateUrl('library_reset'),
        ];

        return $this->render('library.html.twig', $data);
    }
}
