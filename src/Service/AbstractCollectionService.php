<?php

namespace App\Service;

use App\Model\IModelCollection;

abstract class AbstractCollectionService
{
  protected $model;

  public function __construct(IModelCollection $model){
    $this->model = $model;
  }

  public function getErrors(){
    return $this->model->getErrors();
  }
  public function hasErrors(){
    return $this->model->hasErrors();
  }

  abstract function import(array $item): void;
}