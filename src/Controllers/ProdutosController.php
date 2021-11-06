<?php

namespace App\Controllers;

use App\Models\Produtos;
use App\Middlewares\AdminMiddleware;

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
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]))
    {
      Produtos::insert($data);
    }
  }

  public function patch($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]) && $id && $data)
    {
      Produtos::update($id, $data);
    }
  }

  public function delete($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]) && $id)
    {
      Produtos::delete($id);
    }
  }
}