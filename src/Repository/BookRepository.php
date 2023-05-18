<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @SuppressWarnings(PHPMD)
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array<string, string>
     */
    public function findBookByIsbn(string $isbn): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Book b
            WHERE b.isbn = :isbn'
        )->setParameter('isbn', $isbn);

        return $query->getResult();
    }

    /**
     * @return Book
     */
    public function findPreviousBook(int $anId, array $books): Book
        {
        foreach ($books as $bookIndex => $book) {
            if ($book->getId() === $anId) {
                $previousIndex = ($bookIndex === 0) ? count($books) - 1 : $bookIndex - 1;
                return $books[$previousIndex];
            }
        }

        throw new NotFoundHttpException('No previous book found');
    }

    /**
     * @return Book
     */
    public function findNextBook(int $anId, array $books): Book
    {
        foreach ($books as $bookIndex => $book) {
            if ($book->getId() === $anId) {
                $nextIndex = ($bookIndex === count($books) - 1) ? 0 : $bookIndex + 1;
                return $books[$nextIndex];
            }
        }

        throw new NotFoundHttpException('No next book found');

    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
