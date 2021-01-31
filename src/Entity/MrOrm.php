<?php

namespace App\Entity;

class MrOrm
{
	private static $entityManager;

	public static function setEntityManager($entityManager)
	{
		self::$entityManager = $entityManager;
	}

	/**
	 * Load single object by ID
	 *
	 * @param int $id
	 * @return object|null
	 */
	public static function load(int $id): ?object
	{
		return self::$entityManager->getRepository(static::class)->find($id);
	}

	/**
	 *
	 * Load single object by criteria
	 *
	 * @param array $field_value
	 * @return object|null
	 */
	public static function loadBy(array $field_value): ?object
	{
		return self::$entityManager->getRepository(static::class)->findOneBy($field_value);
	}

	/**
	 * Save object
	 */
	public function save()
	{
		self::$entityManager->persist($this);
		self::$entityManager->flush($this);
	}
}