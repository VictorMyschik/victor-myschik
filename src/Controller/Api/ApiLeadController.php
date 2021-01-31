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
	 * @return JsonResponse
	 */
	public function list(): JsonResponse
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
	 * Create lead or add book to old lead
	 *
	 * @param Request $request
	 * @param int $book_id
	 * @return JsonResponse
	 */
	public function add(Request $request, int $book_id): JsonResponse
	{
		$em = $this->getDoctrine()->getManager();
		MrOrm::setEntityManager($em);

		$v = $this->v($request);

		$identifier = $this->getUserIdentifier();
		$phone = $v['phone'] ?? null;
		$address = $v['address'] ?? null;

		/** @var MrBook $book */
		$book = MrBook::load($book_id);

		if (!$book || !$book->isExistence())
		{
			return $this->response(["Book not found or is not existence"], 422);
		}

		/** @var MrLead $lead */
		$lead = MrLead::loadBy([
				'identifier' => $identifier,
				'status'     => MrLead::STATUS_NEW,
		]);

		// If is new client or new lead
		if (!$lead)
		{
			$lead = new MrLead();
			$lead->setStatus(MrLead::STATUS_NEW);
			$lead->setIdentifier($identifier);
		}

		// Client can change phone or address
		if ($phone)
		{
			$lead->setPhone($phone);
		}

		if ($address)
		{
			$lead->setAddress($address);
		}

		$lead->addBookid($book);
		$lead->save();

		return $this->response(['Book added to lead']);
	}

	/**
	 * Sent lead client to work
	 */
	public function sentLead(): JsonResponse
	{
		$em = $this->getDoctrine()->getManager();
		MrOrm::setEntityManager($em);

		$identifier = $this->getUserIdentifier();
		/** @var MrLead $lead */
		$lead = MrLead::loadBy([
				'identifier' => $identifier,
				'status'     => MrLead::STATUS_NEW,
		]);

		if ($lead)
		{
			$lead->setStatus(MrLead::STATUS_WORK);
			$lead->save();

			$out = ['Thank you, your application has been sent.'];
		} else
		{
			$out = ['Please, add book to create lead.'];
		}

		return $this->response($out);
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

	/**
	 * Manege lead
	 *
	 * @param Request $request
	 * @param int $lead_id
	 * @return JsonResponse
	 */
	public function changeLeadStatus(Request $request, int $lead_id): JsonResponse
	{
		$em = $this->getDoctrine()->getManager();
		MrOrm::setEntityManager($em);

		/** @var MrLead $lead */
		$lead = MrLead::load($lead_id);
		$user = $this->getUser();

		if (!$user || !$lead || !$lead->canEdit($user))
		{
			return $this->response([self::ACCESS_VIOLATION], 503);
		}

		$v = $this->v($request);

		if ($v['status'] ?? null)
		{
			$lead->setStatus((int)$v['status']);
		}

		$lead->save();

		return $this->response(['Lead edited']);
	}
}