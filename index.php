<?php
require 'src/routing/Router.php';
include 'src/hello.html;';

//echo 'Hi';

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

$request = new Request($_GET, $_POST, $_SERVER["REQUEST_URI"]);

$router = new Router($request);

$response = $router->response();

echo $response;


/*echo $r;/

//$controller;
/*
if ($r == "/hello") {
	
	$controller = new HelloController();
	
	$controller->response();
}

 */