<?php

namespace App\Lego;

trait MrDescriptionNullableFieldTrait
{
  public function getDescription(): ?string
  {
    return $this->Description;
  }

  public function setDescription(?string $value): void
  {
    $this->Description = $value;
  }
}