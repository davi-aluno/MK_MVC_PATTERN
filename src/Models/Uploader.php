<?php

namespace App\Models;

class Uploader
{
  public static function upload($data)
  {
    date_default_timezone_set("Brazil/East");

    $image_info = @getimagesize($data['tmp_name']);

    if ($image_info == false)
    {
      $response = [
        'erro' => 'Please upload valid image file.'
      ];

      echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else
    {
      $ext = strtolower(substr($data['name'], - 4));
      $new_name = date("Y.m.d-H.i.s") . $ext;
      $dir = 'uploads/';
  
      move_uploaded_file($data['tmp_name'], $dir . $new_name);
  
      $response = [
        'link' => 'https://mk-info.herokuapp.com/uploads/' . $new_name
      ];
  
      echo json_encode($response, JSON_PRETTY_PRINT);
    }
  }
}
