<?php

namespace App\Exception;

class InvalidFileException extends \Exception{
  public function __construct($message, $code = 0, Throwable $previous = null) {
    // некоторый код
    echo 1111;
    // убедитесь, что все передаваемые параметры верны
    parent::__construct($message, $code, $previous);
  }
}