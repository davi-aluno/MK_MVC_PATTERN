<?php

namespace App\Controllers;

use App\Models\Fornecedores;
use App\Middlewares\AdminMiddleware;

class FornecedoresController
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
          return Fornecedores::get($id);
        }
        else
        {
          return Fornecedores::getAll();
        }
      }
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
        Fornecedores::insert($data);
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
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]))
      {
        if ($id && $data)
        {
          Fornecedores::update($id, $data);
        }
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
      if (!empty($matches[1]) && AdminMiddleware::verify($matches[1]))
      {
        if ($id)
        {
          Fornecedores::delete($id);
        }
      }
    }
  }
}
