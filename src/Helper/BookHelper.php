<?php

namespace App\Helper;

use App\Entity\MrBook;
use App\Entity\MrLead;

class BookHelper
{
	/**
	 * Convert books to array
	 *
	 * @param MrBook[] $books
	 * @return array
	 */
	public static function toOut(array $books): array
	{
		$out = array();

		foreach ($books as $book)
		{
			$out[] = self::toSingleBookOut($book);
		}

		return $out;
	}

	/**
	 * Return info about single book
	 *
	 * @param MrBook $book
	 * @return array
	 */
	public static function toSingleBookOut(MrBook $book): array
	{
		$author_out = array();

		foreach ($book->getAuthors() as $author)
		{
			$author_out[] = $author->getName();
		}

		return array(
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

	/**
	 *
	 *
	 * @param MrLead[] $leads
	 * @return array
	 */
	public static function toLeadsOut(array $leads): array
	{
		$out = array();

		foreach ($leads as $lead)
		{
			$out[] = self::getSingleLeadOut($lead);
		}

		return $out;
	}

	/**
	 * Get all info about single lead
	 *
	 * @param MrLead $lead
	 * @return array
	 */
	public static function getSingleLeadOut(MrLead $lead): array
	{
		$bookOut = array();

		foreach ($lead->getBookid() as $book)
		{
			$bookOut[] = self::toSingleBookOut($book);
		}

		return array(
				'status' => $lead->getStatusName(),
				'client' => [
						'phone'   => $lead->getPhone(),
						'address' => $lead->getAddress(),
				],
				'books'  => $bookOut,
		);
	}
}