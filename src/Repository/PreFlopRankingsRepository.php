<?php

namespace App\Repository;

use App\Entity\PreFlopRankings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreFlopRankings>
 *
 * @SuppressWarnings(PHPMD)
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
     * @return PreFlopRankings[]
     */
    public function findCardRanking(string $cards, string $aType): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\PreFlopRankings b
            WHERE b.cards = :cards
            AND b.type = :aType'
        )->setParameter('cards', $cards)
        ->setParameter('aType', $aType);

        return $query->getResult();
    }

    /**
     * Finds two hole cards by ranking.
     *
     * @param int $rank
     *
     * @return PreFlopRankings[] Returns an array of PreFlopRankings objects
     */
   public function findByRank($rank): array
   {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT b
            FROM App\Entity\PreFlopRankings b
            WHERE b.rank = :rank'
       )->setParameter('rank', $rank);

       return $query->getResult();
   }

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
