<?php

namespace App\Controllers;

use App\Models\Consultuser;
use App\Middlewares\UsuarioMiddleware;

class ConsultuserController
{
  public function get($id = null) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    
    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (UsuarioMiddleware::verify($matches[1], $id) && $id)
      {
        Consultuser::get($id);
      }
    }
  }
}