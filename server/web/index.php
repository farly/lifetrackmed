<?php

require __DIR__. DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "bootstrap.php";

use app\config\Routes;
use app\lib\HttpParameters;
use app\controllers;


$method = strtolower($_SERVER['REQUEST_METHOD']);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
if (strtolower($method) === 'options') {
	echo json_encode(['ok' => true]);
	return;
}

$routes = new Routes();
$controller = $routes->matchRoute(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/', $method);

$postParameter = json_decode(file_get_contents('php://input'), true);

$parameters = new HttpParameters($_GET, $postParameter);


try {
	$controller = new $controller(); 
	$response = $controller->execute($method, $parameters->all());
	echo json_encode($response);
} catch (\Exception $error) {
	die((new \Exception($error->getMessage()))->getMessage());
}
