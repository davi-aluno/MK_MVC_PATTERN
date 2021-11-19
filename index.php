<?php

header('Content-Type: application/json');
function cors() {

  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
      // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
      // you want to allow, and if so:
      header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
      header('Access-Control-Allow-Credentials: true');
      header('Access-Control-Max-Age: 86400');    // cache for 1 day
  }

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
          // may also be using PUT, PATCH, HEAD etc
          header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");         

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
          header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

      exit(0);
  }
}
cors();

require_once 'vendor/autoload.php';

if (isset($_GET['url']))
{
  $url = explode('/', $_GET['url']);

  if ($url[0] === 'api')
  {
    array_shift($url);
    
    $controller = 'App\Controllers\\'.ucfirst($url[0]).'Controller';
    array_shift($url);

    $method = strtolower($_SERVER['REQUEST_METHOD']);
    
    try
    {
      $response = call_user_func_array(array(new $controller, $method), $url);

      http_response_code(200);
      if ($response)
      {
        echo json_encode(array($response));
      }
      exit;
    }
    catch (\Exception $e)
    {
      http_response_code(404);
      echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
      exit;
    }
  }
}
