<?php

namespace App\Entity;

class MrOrm
{
	private static $entityManager;

	public static function setEntityManager($entityManager)
	{
		self::$entityManager = $entityManager;
	}

	public static function load(int $id): ?object
	{
		return self::$entityManager->getRepository(static::class)->find($id);
	}

	public static function loadBy(array $field_value): array
	{
		return self::$entityManager->getRepository(static::class)->findBy($field_value);
	}
}