<?php

namespace App\Models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Middlewares\UsuarioMiddleware;

class Usuarios
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
      throw new \Exception("Nenhum usuário encontrado!");
    }
  }

  public static function insert($data)
  {
    $data = json_decode($data, true);
    
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $verifyIfUserExistSQL = 'SELECT email FROM '.self::$table.' WHERE email = :el';
    $verifyIfUserExist = $connectionPDO->prepare($verifyIfUserExistSQL);
    $verifyIfUserExist->bindValue(':el', $data['email']);
    $verifyIfUserExist->execute();

    if ($verifyIfUserExist->rowCount() > 0)
    {
      $response = [
        'status' => 'Usuário já está cadastrado.'
      ];
      echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else
    {
      $sql = 'INSERT INTO '.self::$table.' (nome, email, cpf, senha, status) VALUES (:nm, :el, :cf, :sh, 1)';
      $stmt = $connectionPDO->prepare($sql);
      $stmt->bindValue(':nm', $data['nome']);
      $stmt->bindValue(':el', $data['email']);
      $stmt->bindValue(':cf', $data['cpf']);
      $stmt->bindValue(':sh', password_hash($data['senha'], PASSWORD_DEFAULT));
      $stmt->execute();

      $response = [
        'status' => 'Usuário cadastrado com sucesso!'
      ];
      echo json_encode($response, JSON_PRETTY_PRINT);
    }
  }
  
  public static function update($id, $data)
  {
    $data = json_decode($data, true);
    
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    
    foreach ($data as $key => $value)
    {     
      $sql = 'UPDATE '.self::$table.' SET '.$key.' = :vl WHERE id = :id';
      $stmt = $connectionPDO->prepare($sql);
      if ($key !== 'senha')
      {
        $stmt->bindValue(':vl', $value);
      }
      else
      {
        $stmt->bindValue(':vl', password_hash($value, PASSWORD_DEFAULT));
      }
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    }

    $response = [
      'status' => 'Informações de usuário atualizadas.'
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
  }
  
  public static function delete($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    
    $sql = 'UPDATE '.self::$table.' SET status = 0 WHERE id = :id';
    
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $response = [
      'status' => 'Usuário inativado.'
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
  }
}
