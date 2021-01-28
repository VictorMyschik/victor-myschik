<?php

namespace App\Repository;

use App\Entity\MrBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MrBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method MrBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method MrBook[]    findAll()
 * @method MrBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MrBookRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, MrBook::class);
  }

  public function getBookCount()
  {
    return $this->createQueryBuilder('t')
      ->select('count(t.id)')
      ->getQuery()
      ->getSingleScalarResult();
  }

  /**
   * Get books by parameters
   *
   * @param array $parameters
   * @return array
   */
  public function getByParameters(array $parameters): array
  {
    $query = $this->createQueryBuilder('t')
      ->setFirstResult($parameters['page'])
      ->setMaxResults($parameters['on_page']);

    $paginator = new Paginator($query, $fetchJoinCollection = true);

    $result = array();

    foreach ($paginator as $post)
    {
      $result[] = $post;
    }

    return $result;
  }


  /**
   * Get books by parameters
   *
   * @param array $parameters
   * @return array
   */
  public function searchBooks(array $parameters): array
  {
    $query = $this->createQueryBuilder('t')
      ->where('t.name LIKE :query_text')
      ->setParameter('query_text', pg_escape_literal$parameters['query_text'])
      ->setFirstResult($parameters['page'])
      ->setMaxResults($parameters['on_page']);

    $paginator = new Paginator($query, $fetchJoinCollection = true);

    $result = array();
    

    foreach ($paginator as $post)
    {
      $result[] = $post;
    }

    return $result;
  }


}
