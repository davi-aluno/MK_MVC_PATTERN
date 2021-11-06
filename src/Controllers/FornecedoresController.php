<?php

namespace App\Controllers;

use App\Models\Fornecedores;
use App\Middlewares\AdminMiddleware;

class FornecedoresController
{
  public function get($id = null) 
  {
    if (!empty($_GET["api_key"]) && AdminMiddleware::verify($_GET["api_key"]))
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

  public function post() 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]))
    {
      Fornecedores::insert($data);
    }
  }

  public function patch($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]))
    {
      if ($id && $data)
      {
        Fornecedores::update($id, $data);
      }
    }
  }

  public function delete($id) 
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!empty($data["api_key"]) && AdminMiddleware::verify($data["api_key"]))
    {
      if ($id)
      {
        Fornecedores::delete($id);
      }
    }
  }
}