<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeZone;

class Quote
{
    #[Route("/api/quote")]
    public function jsonNumber(): JsonResponse
    {
        $quote = [
            "Muddy water is best cleared by leaving it alone.",
            "We cannot be more sensitive to pleasure without being more sensitive to pain.",
            "Problems that remain persistently insoluble should always be suspected as questions asked in the wrong way.",
            "Try to imagine what it will be like to go to sleep and never wake up... now try to imagine what it was like to wake up having never gone to sleep.",
            "You are an aperture through which the universe is looking at and exploring itself."
        ];

        $index = random_int(0, count($quote)-1);

        $date = new DateTime("now", new DateTimeZone('Europe/Stockholm'));

        $data = [
            'quote' => $quote[$index],
            'datum' => date("Y-m-d"),
            'klockslag' => $date->format("h:i:s"),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
