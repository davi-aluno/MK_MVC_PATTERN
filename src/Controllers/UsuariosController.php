<?php

namespace App\Controllers;

use App\Models\Usuarios;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\UsuarioMiddleware;

class UsuariosController
{
  public function get($id = null) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    
    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]))
      {
        if ($id)
        {
          return Usuarios::get($id);
        }
        else
        {
          return Usuarios::getAll();
        }
      }
    }
  }

  public function post() 
  {
    $data = file_get_contents('php://input');
    Usuarios::insert($data);
  }

  public function patch($id) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    $data = file_get_contents('php://input');

    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (UsuarioMiddleware::verify($matches[1], $id) || AdminMiddleware::verify($matches[1]) && $id && $data)
      {
        Usuarios::update($id, $data);
      }
    }
  }

  public function delete($id) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];

    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (UsuarioMiddleware::verify($matches[1], $id) || AdminMiddleware::verify($matches[1]) && $id)
      {
        Usuarios::delete($id);
      }
    }
  }
}
