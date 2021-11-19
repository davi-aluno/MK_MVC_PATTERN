<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminMiddleware
{
  private static $table = 'usuarios';

  public static function verify($token)
  {
    $connectionPDO = new \PDO(DBDRIVE . ':host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

    $decoded = JWT::decode($token, new Key(PUBLIC_KEY, 'RS256'));
    $decoded_array = (array) $decoded;
    
    $email = $decoded_array['email'];
    $senha = $decoded_array['senha'];
    
    $verifyIfUserIsValid = 'SELECT * FROM ' . self::$table . ' WHERE email = :em AND status = \'1\'';
    $verify = $connectionPDO->prepare($verifyIfUserIsValid);
    $verify->bindValue(':em', $email);
    $verify->execute();

    $db = $verify->fetch(\PDO::FETCH_ASSOC);

    return $verify->rowCount() > 0 &&
           password_verify($senha, $db['senha']) &&
           $db['email'] === 'admin@gmail.com';
  }
}
