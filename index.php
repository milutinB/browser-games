<?php
require 'src/routing/Router.php';
include 'src/hello.html;';

//echo 'Hi';

if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { 
    $url = 'https://' . $_SERVER['HTTP_HOST']
                      . $_SERVER['REQUEST_URI'];
    header('Location: ' . $url);
    die();
}

$request = new Request($_GET, $_POST, $_SERVER["REQUEST_URI"]);

$router = new Router($request);

$response = $router->response();

echo $response;

