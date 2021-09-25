<?php

namespace App\Model;

final class CategoryModel extends AbstractModelCollection
{
  public string $tableName = 'categories';

  public function getCollection()
  {
    foreach ($this->table as $category) {
//      echo $category->id;
    }
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

    return !!($this->table->insert($data));
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
      $this->addError(sprintf('Record with title "%s" is already set', $data['title']));
      $result = false;
    }

    // if (some another condition)
    //  $this->addError('Invalid data: ' . implode(', ', $data));
    return $result;
  }


}
