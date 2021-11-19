<?php

namespace App\Models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login
{
  private static $table = 'usuarios';

  public static function verify($data)
  {
    $data = json_decode($data, true);

    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table.' WHERE email = :em AND status = \'1\'';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':em', $data['email']);
    $stmt->execute();

    $db = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0 && password_verify($data['senha'], $db['senha']))
    {
      $payload = [
        'email' => $data['email'],
        'senha' => $data['senha']
      ];

      $token = JWT::encode($payload, PRIVATE_KEY, 'RS256');
      $response = [
        'token' => $token,
        'usuario_id' => $db['id']
      ];

      echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
      echo 'Usuário ou senha invalidos.';
    }
  }
}
