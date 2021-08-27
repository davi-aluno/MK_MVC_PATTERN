<?php

namespace App\Controllers;

use App\Models\Produtos;

class ProdutosController
{  
  public function get($id = null) 
  {
    if ($id)
    {
      return Produtos::get($id);
    }
    else
    {
      return Produtos::getAll();
    }
  }

  public function post() 
  {
    $data = file_get_contents('php://input');
    Produtos::insert($data);
  }

  public function patch($id) 
  {
    $data = file_get_contents('php://input');
    if ($id && $data)
    {
      Produtos::update($id, $data);
    }
  }

  public function delete($id) 
  {
    if ($id)
    {
      Produtos::delete($id);
    }
  }
}