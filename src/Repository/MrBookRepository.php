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
		return $this->createQueryBuilder('b')
				->where('b.name LIKE :query_text')
				->orWhere('b.description LIKE :query_text')
				->orWhere('b.year = ' . (int)$parameters['query_text'])
				->setParameter('query_text', '%' . htmlspecialchars($parameters['query_text']) . '%')
				->setMaxResults($parameters['max_result'])
				->getQuery()
				->getResult();
	}

	/**
	 * Convert object to array
	 *
	 * @param array $books
	 * @return array
	 */
	public function toOut(array $books): array
	{
		$out = array();

		foreach ($books as $book)
		{
			/// authors
			$author_out = array();

			foreach ($book->getAuthors() as $author)
			{
				$author_out[] = $author->getName();
			}

			$out[] = array(
					'id'        => $book->getId(),
					'name'      => $book->getName(),
					'page_cnt'  => $book->getPageCnt(),
					'price'     => $book->getPrice(),
					'existence' => $book->getExistenceName(),
					'year'      => $book->getYear(),
					'isbn'      => $book->getIsbn(),
					'url'       => $book->getUrl(),
					'authors'   => $author_out,
			);
		}

		return $out;
	}
}

