<?php

namespace App\Helper;

use \Nette\Caching\Storages\MemoryStorage;
use \Nette\Database\{Connection, Conventions, Structure, Explorer};

class DbHelper
{
  private $explorer;

  public function __construct()
  {
    $dsn = "pgsql:host=${_ENV['DB_HOST']};port=${_ENV['DB_PORT']};dbname=${_ENV['DB_NAME']};user=${_ENV['DB_USER_NAME']};password=${_ENV['DB_USER_PASSWORD']}";
    $dbConnection = new Connection($dsn);

    $dbCache = new MemoryStorage();
    $dbStructure = new Structure($dbConnection, $dbCache);
    $dbConventions = new Conventions\DiscoveredConventions($dbStructure);
    $explorer = new Explorer($dbConnection, $dbStructure, $dbConventions, $dbCache);

//    $this->db = $dbConnection;
    $this->explorer = $explorer;
  }

  public function getExplorer(): Explorer
  {
    return $this->explorer;
  }

}