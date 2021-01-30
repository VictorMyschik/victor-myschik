<?php

namespace App\Controller\Api;

use App\Entity\MrBook;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiBookController extends ApiBaseController
{
	/**
	 * Return list of books
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function list(Request $request): JsonResponse
	{
		$repository = $this->getDoctrine()->getRepository(MrBook::class);
		$parameters = $this->getStandardParameters($request->query->getIterator()->getArrayCopy());

		$books = $repository->getByParameters($parameters);
		$books_out = $repository->toOut($books);

		// TODO: do with cache in future
		$cnt_books = $repository->getBookCount();

		$out = array(
				'books'   => $books_out,
				'cnt'     => count($books_out),
				'cnt_all' => $cnt_books
		);

		return $this->response($out);
	}

	// Standard parameters for get books
	const CNT_ON_PAGE = 10;
	const PAGE = 1; // number of page

	/**
	 * Check parameters or get base (if not valid)
	 *
	 * @param array $query_arr
	 * @return int[]
	 */
	public function getStandardParameters(array $query_arr): array
	{
		return array(
				'on_page' => (int)($query_arr['on_page'] ?? self::CNT_ON_PAGE),
				'page'    => (int)($query_arr['page'] ?? self::PAGE)
		);
	}
}