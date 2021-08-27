<?php

namespace App\Controllers;

use App\Models\Pedidos;

class PedidosController
{  
  public function get($id = null) 
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

  public function post() 
  {
    $data = file_get_contents('php://input');
    Pedidos::insert($data);
  }

  public function patch($id) 
  {
    $data = file_get_contents('php://input');
    if ($id && $data)
    {
      Pedidos::update($id, $data);
    }
  }

  public function delete($id) 
  {
    if ($id)
    {
      Pedidos::delete($id);
    }
  }
}
