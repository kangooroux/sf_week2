<?php

namespace App\Repository;

use App\Entity\Record;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Record|null find($id, $lockMode = null, $lockVersion = null)
 * @method Record|null findOneBy(array $criteria, array $orderBy = null)
 * @method Record[]    findAll()
 * @method Record[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    // /**
    //  * @return Record[] Returns an array of Record objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Record
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Albums sortis il y a moins d'un mois
     */
    public function findNewRecords()
    {
        // 'r' est un alias de Record
        return $this->createQueryBuilder('r')
            ->where('r.releasedDate >= :last_30_days')
            ->setParameter('last_30_days', new \DateTime('-30 days'))
            ->orderBy('r.releasedDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Albums d'une maison de prod
     */
    public function findRecordsFromProducer($id)
    {
        // 'r' est un alias de Record
        return $this->createQueryBuilder('r')
            ->where('r.producer = ' . $id)
            ->getQuery()
            ->getResult()
            ;
    }
}
