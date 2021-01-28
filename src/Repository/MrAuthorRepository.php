<?php

namespace App\Repository;

use App\Entity\MrAuthor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MrAuthor|null find($id, $lockMode = null, $lockVersion = null)
 * @method MrAuthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method MrAuthor[]    findAll()
 * @method MrAuthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MrAuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MrAuthor::class);
    }



    // /**
    //  * @return MrBook[] Returns an array of MrBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MrBook
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
