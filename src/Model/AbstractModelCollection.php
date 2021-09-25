<?php

namespace App\Model;

use App\Helper\DbHelper;

abstract class AbstractModelCollection implements IModelCollection
{
  protected $db;
  protected $explorer;

  protected $output;
  protected $table;
  protected array $errors = [];

  public string $tableName;

  public function __construct(DbHelper $db)
  {
    $this->db = $db;
    $this->explorer = $db->getExplorer();
    $this->table = $this->explorer->table($this->getTableName());
  }

  public function getTableName(): string
  {
    return $this->tableName;
  }

  public function addError(string $message){
    $this->errors[] = $message;
  }

  public function hasErrors(){
    return (!empty($this->getErrors()));
  }

  public function getErrors():array{
    return $this->errors;
  }

  public function isExistByField(string $field, $criteria): bool
  {
    // TODO правильный запрос, но выдает не верное кол-во - не разбирался
    //    $result = $this->table->where($field, $criteria)->limit(1);

    // TODO не правильный запрос, но работает правильно
    $result = $this->explorer->query('SELECT 1 FROM ' . $this->tableName . ' WHERE ' . $field . ' = ?', $criteria);
    return !!($result->getRowCount());
  }

  abstract protected function validate(array $data):bool;

}