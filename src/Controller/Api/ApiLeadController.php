<?php

namespace App\Controller\Api;

use App\Entity\MrBook;
use App\Entity\MrLead;
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
				'leads'   => $leads_out,
				'cnt'     => count($leads_out),
		);

		return $this->response($out);
	}

	public function getUserIdentifier(): string
	{
		$r = $_SERVER['REMOTE_ADDR'];
		$r .= $_COOKIE['PHPSESSID'] ?? '';
		$r = md5($r);

		return $r;
	}
}