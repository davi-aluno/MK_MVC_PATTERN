<?php

namespace App\Models;

class Userpurchases
{
  private static $table = 'pedidos';

  public static function getPurchases($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table.' WHERE usuario_id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum pedido encontrado!");
    }
  }
}