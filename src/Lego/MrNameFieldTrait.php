<?php

namespace App\Lego;

trait MrNameFieldTrait
{
  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $value): void
  {
    $this->name = $value;
  }
}