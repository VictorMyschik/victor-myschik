<?php

namespace App\Controller\Api;

use App\Entity\MrBook;
use App\Form\MrBookType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiBookController extends ApiBaseController
{
	protected $queryParameters;

	public function __construct(RequestStack $requestStack)
	{
		$this->queryParameters = $requestStack->getCurrentRequest()->query->getIterator()->getArrayCopy();
	}

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

	/**
	 * Info about single book
	 *
	 * @param int $book_id
	 * @return JsonResponse
	 */
	public function view(int $book_id): JsonResponse
	{
		$repository = $this->getDoctrine()->getRepository(MrBook::class);

		/** @var MrBook $book */
		if ($book = $repository->find($book_id))
		{
			$out = $repository->toSingleBookOut($book);
			return $this->response($out);
		} else
		{
			$out = ['Book not found'];
			return $this->response($out, 404);
		}
	}

	// Constants for search books
	const MAX_LENGTH_SEARCH_TEXT = 100;
	const MAX_RESULT = 10;

	/**
	 * Search book
	 * Parameters: search - string query, max length = 100 symbols
	 *             limit - max result
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function searchBook(Request $request): JsonResponse
	{
		$books = array();
		$repository = $this->getDoctrine()->getRepository(MrBook::class);

		$query_param = $request->query->getIterator()->getArrayCopy();
		$limit = $query_param['limit'] ?? self::MAX_RESULT;

		if ($query_text = $query_param['search'] ?? '')
		{
			$parameters = array(
					'query_text' => substr($query_text, 0, self::MAX_LENGTH_SEARCH_TEXT),
					'max_result' => (int)$limit <= self::MAX_RESULT ? (int)$limit : self::MAX_RESULT, // disable get all catalog
			);

			$books = $repository->searchBooks($parameters);
		}

		$searchedCnt = count($books);

		$out = array();
		$out['searchedCnt'] = $searchedCnt;

		if ($searchedCnt)
		{
			$out['books'] = $repository->toOut($books);
		}

		return $this->response($out);
	}

	/**
	 * Create new book
	 *
	 * @return JsonResponse
	 */
	public function new(Request $request): JsonResponse
	{
		/*$user = $this->getUser();
		if (!$user || !$user->isAdmin())
		{
			return $this->response([self::ACCESS_VIOLATION], 503);
		}*/

		try
		{
			$v = $request->request->all();

			$mrBook = new MrBook();

			$form = $this->createForm(MrBookType::class, $mrBook);
			$form->submit($v);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($mrBook);
			$entityManager->flush();

			$out = array(
					'created' => 'success',
					'id'      => $mrBook->getId(),
			);
		} catch (\Exception $e)
		{
			$out = array(
					'created' => 'error',
					'message' => $e->getMessage(),
			);
		}

		return $this->response($out);
	}

	/**
	 * Delete book
	 *
	 * @param int $book_id
	 * @return JsonResponse
	 */
	public function delete(int $book_id): JsonResponse
	{
		$repository = $this->getDoctrine()->getRepository(MrBook::class);

		/** @var MrBook $book */
		if ($book = $repository->find($book_id))
		{
			if (!$this->getUser() || !$book->canDelete($this->getUser()))
			{
				return $this->response([self::ACCESS_VIOLATION], 503);
			}

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($book);
			$entityManager->flush();

			return $this->response(['deleted']);
		} else
		{
			$out = ['Book not found'];
			return $this->response($out, 404);
		}
	}
}