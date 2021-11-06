<?php

namespace App\Controllers;

use App\Models\Usuarios;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\UsuarioMiddleware;

class UsuariosController
{
  public function get($id = null) 
  {
    if (!empty($_GET["api_key"]) && AdminMiddleware::verify($_GET["api_key"]))
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

  public function post() 
  {
    $data = file_get_contents('php://input');
    Usuarios::insert($data);
  }

  public function patch($id) 
  {
    $data = file_get_contents('php://input');
    
    if (UsuarioMiddleware::verify($data, $id) && $id && $data)
    {
       Usuarios::update($id, $data);
    }
  }

  public function delete($id) 
  {
    $data = file_get_contents('php://input');
    
    if (UsuarioMiddleware::verify($data, $id) && $id)
    {
      Usuarios::delete($id);
    }
  }
}