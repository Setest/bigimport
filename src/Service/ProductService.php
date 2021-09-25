<?php

namespace App\Service;

final class ProductService extends AbstractCollectionService implements ICollectionService
{
  public function import(array $item): void
  {
    $this->model->insert($item);
  }
}