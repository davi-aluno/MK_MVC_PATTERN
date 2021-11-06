<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UsuarioMiddleware
{
  private static $table = 'usuarios';

  public static function verify($data, $id)
  {
    $connectionPDO = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
    $data = json_decode($data, true);

    $token = $data['api_key'];

    $decoded = JWT::decode($token, new Key(PUBLIC_KEY, 'RS256'));
    $decoded_array = (array) $decoded;
    
    $email = $decoded_array['email'];
    $senha = $decoded_array['senha'];
    
    $verifyIfUserIsValid = 'SELECT * FROM ' . self::$table . ' WHERE email = :em AND senha = :ps AND status = \'1\' AND id = :id';
    $verify = $connectionPDO->prepare($verifyIfUserIsValid);
    $verify->bindValue(':em', $email);
    $verify->bindValue(':ps', $senha);
    $verify->bindValue(':id', $id);
    $verify->execute();

    $data = $verify->fetch(\PDO::FETCH_ASSOC);

    return $verify->rowCount() > 0 &&
           $data['email'] === $email &&
           $data['senha'] === $senha;
  }
}