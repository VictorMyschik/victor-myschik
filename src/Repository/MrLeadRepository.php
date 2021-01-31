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

	/**
	 * Get aggregated leads by hash-identifier
	 *
	 * @return int|mixed|string
	 */
	public function getLeadsList()
	{
		$param = 'm.identifier, m.phone, m.address, m.status';
		$list = $this->createQueryBuilder('m')
				->select($param)
				->groupBy($param)
				->getQuery()
				->getResult();

		foreach ($list as $key => $item)
		{
			$list[$key]['status'] = MrLead::getStatusList()[$item['status']];
		}

		return $list;
	}

	public function getLeadsCount()
	{

	}
}
