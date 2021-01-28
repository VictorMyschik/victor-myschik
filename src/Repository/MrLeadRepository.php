<?php

namespace App\Repository;

use App\Entity\MrLead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MrLead|null find($id, $lockMode = null, $lockVersion = null)
 * @method MrLead|null findOneBy(array $criteria, array $orderBy = null)
 * @method MrLead[]    findAll()
 * @method MrLead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MrLeadRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, MrLead::class);
  }

  // /**
  //  * @return MrLead[] Returns an array of MrLead objects
  //  */
  /*
  public function findByExampleField($value)
  {
      return $this->createQueryBuilder('m')
          ->andWhere('m.exampleField = :val')
          ->setParameter('val', $value)
          ->orderBy('m.id', 'ASC')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult()
      ;
  }
  */

  /*
  public function findOneBySomeField($value): ?MrLead
  {
      return $this->createQueryBuilder('m')
          ->andWhere('m.exampleField = :val')
          ->setParameter('val', $value)
          ->getQuery()
          ->getOneOrNullResult()
      ;
  }
  */
}
