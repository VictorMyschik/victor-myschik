<?php

namespace App\Controller\Api;

use App\Entity\MrBook;
use App\Entity\MrLead;
use App\Entity\MrOrm;
use App\Helper\BookHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiLeadController extends ApiBaseController
{
	/**
	 * Return list of leads
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function list(Request $request): JsonResponse
	{
		$repository = $this->getDoctrine()->getRepository(MrLead::class);

		$leads = $repository->findAll();
		/** @var MrLead[] $leads */
		$leads_out = BookHelper::toLeadsOut($leads);

		$out = array(
				'leads' => $leads_out,
				'cnt'   => count($leads_out),
		);

		return $this->response($out);
	}

	/**
	 * @param int $book_id
	 * @return JsonResponse
	 */
	public function add(int $book_id): JsonResponse
	{
		$entityManager = $this->getDoctrine()->getManager();
		MrOrm::setEntityManager($entityManager);

		$book = MrBook::load($book_id);

		if (!$book || !$book->isExistence())
		{
			return $this->response(['Book not existence']);
		}

		$identifier = $this->getUserIdentifier();
		$lead = MrLead::loadBy([
				'identifier' => $identifier,
				'status'     => MrLead::STATUS_NEW,
		]);

		dd($lead);

	}

	/**
	 * Get identifier from anonymous client
	 *
	 * @return string
	 */
	public function getUserIdentifier(): string
	{
		$r = $_SERVER['REMOTE_ADDR'];
		$r .= $_COOKIE['PHPSESSID'] ?? ''; // can not be isset
		$r = md5($r);

		return $r;
	}
}