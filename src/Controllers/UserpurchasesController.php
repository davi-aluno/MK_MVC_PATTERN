<?php

namespace App\Controllers;

use App\Models\Userpurchases;
use App\Middlewares\UsuarioMiddleware;

class UserpurchasesController
{
  public function get($id)
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];

    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (UsuarioMiddleware::verify($matches[1], $id))
      {
        Userpurchases::getPurchases($id);
      }
    }
  }
}
