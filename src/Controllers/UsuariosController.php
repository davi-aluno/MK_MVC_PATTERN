<?php

namespace App\Controllers;

use App\Models\Usuarios;

class UsuariosController
{  
  public function get($id = null) 
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

  public function post() 
  {
    $data = file_get_contents('php://input');
    Usuarios::insert($data);
  }

  public function patch($id) 
  {
    $data = file_get_contents('php://input');
    if ($id && $data)
    {
      Usuarios::update($id, $data);
    }
  }

  public function delete($id) 
  {
    if ($id)
    {
      Usuarios::delete($id);
    }
  }
}