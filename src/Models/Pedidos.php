<?php

namespace App\Controllers;

use App\Models\Pedidos;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\UsuarioMiddleware;

class PedidosController
{  
  public function get($id = null) 
  {
    if (AdminMiddleware::verify($_GET["api_key"]))
    {
      if ($id)
      {
        return Pedidos::get($id);
      }
      else
      {
        return Pedidos::getAll();
      }
    }
  }

  public function post() 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!empty($data["api_key"]))
    {
      Pedidos::insert($data);
    }
  }

  public function patch($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]) && $id && $data)
    {
      Pedidos::update($id, $data);
    }
  }

  public function delete($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (AdminMiddleware::verify($data["api_key"]))
    {
      if ($id)
      {
        Pedidos::delete($id);
      }
    }
  }
}