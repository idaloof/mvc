<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiLibraryController extends AbstractController
{
    #[Route('/api/library/books', name: 'api_library_books', methods: ['GET'])]
    public function jsonAllBooks(
        BookRepository $bookRepository
    ): JsonResponse {
        $books = $bookRepository->findAll();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize(
            $books,
            'json',
            ['json_encode_options' => JSON_PRETTY_PRINT]
        );

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/library/book/{isbn}', name: 'api_library_book_isbn', methods: ['GET'])]
    public function jsonOneBook(
        BookRepository $bookRepository,
        string $isbn
    ): JsonResponse {
        $book = $bookRepository->findBookByIsbn($isbn);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize(
            $book,
            'json',
            ['json_encode_options' => JSON_PRETTY_PRINT]
        );

        return new JsonResponse($data, 200, [], true);
    }
}
