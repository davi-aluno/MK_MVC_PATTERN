<?php

namespace App\Controllers;

use App\Middlewares\AdminMiddleware;

class AdminController
{
  public function post()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    
    if (AdminMiddleware::verify($data['token']))
    {
      $response = ['type' => 'admin'];
      echo json_encode($response);
    }
    else
    {
      $response = ['type' => 'user'];
      echo json_encode($response);
    }
  }
}