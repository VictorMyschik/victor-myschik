<?php

namespace App\Repository;

use App\Entity\MrBil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MrBil|null find($id, $lockMode = null, $lockVersion = null)
 * @method MrBil|null findOneBy(array $criteria, array $orderBy = null)
 * @method MrBil[]    findAll()
 * @method MrBil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MrBilRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, MrBil::class);
  }

  public function getBooksWithAuthors()
  {
    $conn = $this->getEntityManager()->getConnection();

    $sql = 'SELECT * FROM user';
    $stmt = $conn->executeQuery($sql);

    dd($stmt->fetchAll());

    return $query->getResult();
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
