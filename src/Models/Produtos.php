<?php

namespace App\Models;

class Produtos
{
  private static $table = 'produtos';

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
      throw new \Exception("Nenhum fornecedor encontrado!");
    }
  }

  public static function getAll()
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table;
    $stmt = $connectionPDO->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum produto encontrado!");
    }
  }

  public static function insert($data)
  {    
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'INSERT INTO '.self::$table.' (nome, imagem, descricao, quantidade, preco, status, fornecedor_id) VALUES (:nm, :ig, :dc, :qt, :pr, 1, :fn)';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':nm', $data['nome']);
    $stmt->bindValue(':ig', $data['imagem']);
    $stmt->bindValue(':dc', $data['descricao']);
    $stmt->bindValue(':qt', $data['quantidade']);
    $stmt->bindValue(':pr', $data['preco']);
    $stmt->bindValue(':fn', $data['fornecedor_id']);
    $stmt->execute();
  }
  
  public static function update($id, $data)
  {    
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    
    foreach ($data as $key => $value)
    {     
      $sql = 'UPDATE '.self::$table.' SET '.$key.' = :vl WHERE id = :id';
      $stmt = $connectionPDO->prepare($sql);
      $stmt->bindValue(':vl', $value);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    }
  }
  
  public static function delete($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'UPDATE '.self::$table.' SET status = 0 WHERE id = :id';
    
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
  }
}
