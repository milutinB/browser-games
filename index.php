<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
require 'src/routing/Router.php';
session_start();


$request = new Request($_GET, $_POST, $_SERVER["REQUEST_URI"]);

$router = new Router($request);

$response = $router->response();

$response->send();

