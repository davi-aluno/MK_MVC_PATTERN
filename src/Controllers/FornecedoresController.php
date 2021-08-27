<?php

namespace App\Controllers;

use App\Models\Fornecedores;

class FornecedoresController
{  
  public function get($id = null) 
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

  public function post() 
  {
    $data = file_get_contents('php://input');
    Fornecedores::insert($data);
  }

  public function patch($id) 
  {
    $data = file_get_contents('php://input');
    if ($id && $data)
    {
      Fornecedores::update($id, $data);
    }
  }

  public function delete($id) 
  {
    if ($id)
    {
      Fornecedores::delete($id);
    }
  }
}