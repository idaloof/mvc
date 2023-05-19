<?php

namespace App\Tests\Controller;

use App\Controller\ApiLibraryController;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiLibraryControllerTest extends KernelTestCase
{
    public function testJsonAllBooks(): void
    {
        $books = [
            (new Book())->setTitle('Book 1')->setIsbn('1234567890'),
            (new Book())->setTitle('Book 2')->setIsbn('0987654321'),
        ];

        $bookRepository = $this->createMock(BookRepository::class);
        $bookRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($books);

        $controller = new ApiLibraryController();
        $response = $controller->jsonAllBooks($bookRepository);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();
        $responseData = is_string($content) ? json_decode($content, true) : null;

        $this->assertIsArray($responseData);
        $this->assertCount(2, $responseData);
    }

    public function testJsonOneBook(): void
    {
        /**
         * @var Book $book
         */
        $book = (new Book())->setTitle('Book 1')->setIsbn('1234567890');

        $bookRepository = $this->createMock(BookRepository::class);
        $bookRepository->expects($this->once())
            ->method('findBookByIsbn')
            ->with('1234567890')
            ->willReturn((array) $book);

        $controller = new ApiLibraryController();
        $response = $controller->jsonOneBook($bookRepository, '1234567890');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();
        $responseData = is_string($content) ? json_decode($content, true) : null;

        $this->assertIsArray($responseData);
        // var_dump($responseData);
    }
}