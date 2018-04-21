<?php
include 'HelloController.php';

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

$r = $_SERVER["REQUEST_URI"];

$controller;

if ($r = "/") {
	
	echo file_get_contents("home.html");
	
} else if ($r == "/hello") {
	$controller = new HelloController();
	
	$controller->response();
}

 