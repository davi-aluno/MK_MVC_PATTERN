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
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]))
      {
        Produtos::insert($data);
      }
    }
  }

  public function patch($id) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]) && $id && $data)
      {
        Produtos::update($id, $data);
      }
    }
  }

  public function delete($id) 
  {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
    {
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]) && $id)
      {
        Produtos::delete($id);
      }
    }
  }
}
