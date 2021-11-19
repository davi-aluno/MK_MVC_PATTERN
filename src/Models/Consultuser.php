<?php

namespace App\Models;

class Consultuser
{
  private static $table = 'usuarios';

  public static function get($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table.' WHERE id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum usuario encontrado!");
    }
  }
}