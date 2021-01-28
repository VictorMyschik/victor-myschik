<?php

namespace App\Controller;

use App\Entity\MrBook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
  // Standard parameters for get books
  const CNT_ON_PAGE = 10;
  const PAGE = 1; // number of page

  /**
   * @param Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $repository = $this->getDoctrine()->getRepository(MrBook::class);
    $parameters = $this->getStandardParameters($request->query->getIterator()->getArrayCopy());

    $books = $repository->getByParameters($parameters);

    // TODO: do with cache in future
    $cnt_books = $repository->getBookCount();

    return $this->render('list/index.html.twig', [
      'books'   => $books,
      'cnt'     => count($books),
      'cnt_all' => $cnt_books
    ]);
  }

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

  const MAX_LENGTH_SEARCH_TEXT = 100;

  /**
   * Search books by text query. Can use standard parameters (on_page, page)
   *
   * @param Request $request
   */
  public function searchBooks(Request $request)
  {
    $repository = $this->getDoctrine()->getRepository(MrBook::class);

    $parameters = $this->getStandardParameters($request->query->getIterator()->getArrayCopy());

    $books = array();

    if ($query_text = $request->query->getIterator()->getArrayCopy()['search'] ?? '')
    {
      $parameters['query_text'] = substr($query_text, 0, self::MAX_LENGTH_SEARCH_TEXT);

      $books = $repository->searchBooks($parameters);
    }

    dd($books);

  }
}
