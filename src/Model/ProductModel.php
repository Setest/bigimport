<?php

namespace App\Model;

use Importer\Model\ICategories;
use Importer\Model\Collection;

final class ProductModel extends AbstractModelCollection
{
  public string $tableName = 'products';

  public function getCollection()
  {
  }

  /**
   * @param array $data
   * @return bool
   */
  public function insert(array $data): bool
  {
    if (!$this->validate($data)){
      return false;
    }

    $data = $this->prepare($data);
    $self =& $this;
    $result = $this->explorer->transaction(static function ($database) use ($data, $self) {

      // TODO тут конечно по другому надо делать, но я решил упростить
      $categoriesEId = $data['categoriesEId'] ?? [];
      $data['categoriesEId'] = $data['categoriesEId'];
      unset($data['categoriesEId']);
      $self->table->insert($data);
      $productId = $database->getInsertId();

      // TODO проверяем существование категории (можно на уровне БД)

      foreach ($categoriesEId as $cid){
        $database->query('INSERT INTO categories_products', [
          'category_id' => $cid,
          'product_id' => $productId,
        ]);
      }

      return $productId;
    });

    return !!($result);
  }

  protected function prepare(array $data): array
  {
    $data['e_id'] = $data['eId'];
    unset ($data['eId']);
    return $data;
  }

  /**
   * Validate something
   *
   * @param array $data
   */
  protected function validate(array $data): bool
  {
    $result = true;
    if (empty($data)) {
      $this->addError('Data is empty');
      $result = false;
    }

    if ($this->isExistByField('title', $data['title'])) {
      $this->addError(sprintf('Data with title "%s" is already set', $data['title']));
      $result = false;
    }

    if ($data['price'] >= 1000) {
      $this->addError(sprintf('Price of "%s" is too big', $data['title']));
      $result = false;
    }

    // if (some another condition)
    //  $this->addError('Invalid data: ' . implode(', ', $data));
    return $result;
  }


}
