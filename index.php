<?php
include 'HelloController.php';


/*if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}*/

header("Location: databaseTest.php");

$r = $_SERVER["REQUEST_URI"];

/*echo $r;/

//$controller;
/*
if ($r == "/hello") {
	
	$controller = new HelloController();
	
	$controller->response();
}

 */