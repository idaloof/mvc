<?php

namespace App\Repository;

use App\Entity\PreFlopRankings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreFlopRankings>
 *
 * @method PreFlopRankings|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreFlopRankings|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreFlopRankings[]    findAll()
 * @method PreFlopRankings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreFlopRankingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreFlopRankings::class);
    }

    public function save(PreFlopRankings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PreFlopRankings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array<string, string>
     */
    public function findCardRanking(string $cards): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\PreFlopRankings b
            WHERE b.cards = :cards'
        )->setParameter('cards', $cards);

        return $query->getResult();
    }

//    /**
//     * @return PreFlopRankings[] Returns an array of PreFlopRankings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PreFlopRankings
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
