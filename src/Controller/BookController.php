<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/create', name: 'book_create')]
    public function createBook(): Response
    {
        return $this->render('book/create.html.twig');
    }

    #[Route('/book/create/post', name: 'book_create_post', methods: ['POST'])]
    public function createBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $bookTitle = (string) $request->request->get("title");
        $bookIsbn = (int) $request->request->get("isbn");
        $bookAuthor = (string) $request->request->get("author");
        $bookImage = (string) $request->request->get("image");

        /**
         * @var Book $book
         */

        $book = new Book();
        $book->setTitle($bookTitle);
        $book->setIsbn($bookIsbn);
        $book->setAuthor($bookAuthor);
        $book->setImage($bookImage);

        // tell Doctrine you want to (eventually) save the book
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('book_create');
    }

    #[Route('/book/read-one/{id}', name: 'book_by_id')]
    public function showOneBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);
        $books = $bookRepository->findAll();

        $nrOfBooks = count($books);
        $nextBook = $bookRepository->find($id + 1);
        $prevBook = $bookRepository->find($id - 1);

        if ($id === $nrOfBooks) {
            $nextBook = $bookRepository->find(1);
        }

        if ($id === 1) {
            $prevBook = $bookRepository->find($nrOfBooks);
        }

        $data = [
            'book' => $book,
            'books' => $books,
            'nrOfBooks' => $nrOfBooks,
            'nextBook' => $nextBook,
            'prevBook' => $prevBook
        ];

        return $this->render('book/show_one.html.twig', $data);
    }

    #[Route('/book/read-many', name: 'book_read_many')]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        return $this->render('book/show_all.html.twig', ['books' => $books]);
    }

    #[Route('/book/update/{anId}', name: 'book_update')]
    public function updateBook(
        BookRepository $bookRepository,
        int $anId
    ): Response {
        $book = $bookRepository->find($anId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$anId
            );
        }

        return $this->render('book/update.html.twig', ['book' => $book]);
    }

    #[Route('/book/update/post/{anId}', name: 'book_update_post', methods: ['POST'])]
    public function updateBookPost(
        ManagerRegistry $doctrine,
        Request $request,
        int $anId
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($anId);

        $bookTitle  = $request->request->get('title');
        $bookIsbn   = $request->request->get('isbn');
        $bookAuthor = $request->request->get('author');
        $bookImage  = $request->request->get('image');

        $book->setTitle($bookTitle);
        $book->setIsbn($bookIsbn);
        $book->setAuthor($bookAuthor);
        $book->setImage($bookImage);

        $entityManager->persist($book);

        $entityManager->flush();
        return $this->redirectToRoute("book_by_id", ['id' => $anId]);
    }

    #[Route('/book/delete/{anId}', name: 'book_delete')]
    public function deleteBook(
        BookRepository $bookRepository,
        int $anId
    ): Response {
        $book = $bookRepository->find($anId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$anId
            );
        }

        return $this->render('book/delete.html.twig', ['book' => $book]);
    }

    #[Route('/book/delete/confirm/{anId}', name: 'book_delete_confirm')]
    public function deleteBookConfirm(
        BookRepository $bookRepository,
        int $anId
    ): Response {
        $book = $bookRepository->find($anId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '. $anId
            );
        }

        return $this->render('book/delete_confirm.html.twig', ['book' => $book]);
    }

    #[Route('/book/delete/post/{anId}', name: 'book_delete_post')]
    public function deleteBookPost(
        ManagerRegistry $doctrine,
        int $anId
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($anId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '. $anId
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book/show_all.html.twig');
    }

    #[Route("/library/reset", name: 'library_reset')]
    public function resetDatabase(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $sql = [
            'DROP TABLE IF EXISTS book;',
            'CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            isbn INTEGER NOT NULL,
            author VARCHAR(255) NOT NULL,
            image VARCHAR(255) NOT NULL);'
        ];

        foreach ($sql as $query) {
            $connection = $doctrine->getConnection();
            $statement = $connection->prepare($query);
            $statement->executeStatement();
        }

        $books = [
            [
                "The More Beautiful World Our Hearts Know Is Possible",
                9781583947241,
                "Charles Eisenstein",
                "Charles.jpg"
            ],
            [
                "438 days",
                9789185279258,
                "Johan Persson, Martin Schibbye",
                "438.jpg"
            ],
            [
                "Faster than Lightning: My Autobiography",
                9780007371426,
                "Usain Bolt",
                "Usain.jpg"
            ],
            [
                "I Am Ozzy",
                9780446569903,
                "Ozzy Ousborne",
                "Ozzy.jpg"
            ],
            [
                "Darwin's Pharmacy",
                9780295990958,
                "Richard M. Doyle",
                "Darwin.jpg"
            ],
            [
                "Steve Jobs",
                9780349140438,
                "Walter Isaacson",
                "Steve.jpg"
            ],
            [
                "Open",
                9780007281435,
                "Andre Agassi",
                "Andre.jpg"
            ]
        ];

        foreach ($books as $book) {
            $aBook = new Book();
            $aBook->setTitle($book[0]);
            $aBook->setIsbn($book[1]);
            $aBook->setAuthor($book[2]);
            $aBook->setImage($book[3]);

            $entityManager->persist($aBook);
        }

        $entityManager->flush();

        return $this->redirectToRoute('library');
    }
}
