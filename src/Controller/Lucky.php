<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Lucky extends AbstractController
{
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
}
