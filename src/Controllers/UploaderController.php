<?php

namespace App\Controllers;

use App\Models\Uploader;

class UploaderController
{
  public function post()
  {
    Uploader::upload($_FILES['image']);
  }
}