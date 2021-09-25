<?php

namespace App\Service;

final class CategoryService extends AbstractCollectionService implements ICollectionService
{
  public function import(array $item): void
  {
    $this->model->insert($item);
  }
}