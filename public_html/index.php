<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");

require_once '../vendor/autoload.php';

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
