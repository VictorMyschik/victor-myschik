<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiBaseController extends AbstractController
{
	const ACCESS_VIOLATION = 'Access violation';

	/**
	 * Returns a JSON response
	 *
	 * @param array $data
	 * @param int $code_status
	 * @param array $headers
	 *
	 * @return JsonResponse
	 */
	protected function response(array $data, int $code_status = 200, array $headers = []): JsonResponse
	{
		$out = array(
				'status'  => $code_status,
				'content' => $data
		);

		return new JsonResponse($out, $code_status, $headers);
	}
}