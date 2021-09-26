<?php

namespace App\Service;

final class CategoryService extends AbstractCollectionService implements ICollectionService
{
  public function import(array $item): void
  {
    // TODO в данном месте если учитывать что категорий мало, то
    // можно получить сразу все данные и хранить их в кешере например
    // далее проверять необходимость вставки. Т.к. импорт вызывается в
    // итераторе, то нужно первичное заполнение либо запихнуть в
    // prepare(), либо добавить проверок на существование заполненного кеша
    // через метод before() например с трайкетчем
    $this->model->insert($item);
  }
}