<?php
require 'src/routing/Router.php';
include 'src/hello.html;';

//echo 'Hi';


$request = new Request($_GET, $_POST, $_SERVER["REQUEST_URI"]);

$router = new Router($request);

$response = $router->response();

echo $response;

