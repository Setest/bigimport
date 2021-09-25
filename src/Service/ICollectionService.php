<?php
namespace App\Service;

interface ICollectionService
{
  public function import(array $item): void;
}