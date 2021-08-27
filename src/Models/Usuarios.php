<?php

namespace App\Models;

class Usuarios
{
  private static $table = 'usuarios';

  public static function get($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM ' . self::$table . ' WHERE id = :id';
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
  
  public static function getAll()
  {
    $connectionPDO = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM ' . self::$table;
    $stmt = $connectionPDO->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum usuário encontrado!");
    }
  }

  public static function insert($data)
  {
    $data = json_decode($data, true);
    
    $connectionPDO = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'INSERT INTO '.self::$table.' (nome, email, cpf, senha, status) VALUES (:nm, :el, :cf, :sh, :st)';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':nm', $data['nome']);
    $stmt->bindValue(':el', $data['email']);
    $stmt->bindValue(':cf', $data['cpf']);
    $stmt->bindValue(':sh', $data['senha']);
    $stmt->bindValue(':st', $data['status']);
    $stmt->execute();
  }
  
  public static function update($id, $data)
  {
    $data = json_decode($data, true);
    
    $connectionPDO = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
    
    foreach ($data as $key => $value)
    {     
      $sql = 'UPDATE ' . self::$table . ' SET ' . $key . ' = :vl WHERE id = :id';
      
      $stmt = $connectionPDO->prepare($sql);
      $stmt->bindValue(':vl', $value);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    }
  }
  
  public static function delete($id)
  {
    $connectionPDO = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

    $sql = 'UPDATE ' . self::$table . ' SET status = "inativo" WHERE id = :id';
    
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
  }
}
