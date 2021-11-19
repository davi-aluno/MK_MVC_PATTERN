<?php

namespace App\Controllers;

use App\Models\Login;

class LoginController
{
  public function post()
  {
    $data = file_get_contents('php://input');
    Login::verify($data);
  }
}
