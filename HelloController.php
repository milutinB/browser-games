<?php
error_reporting(E_ALL);
class HelloController {
	function __construct() {
	}
	
	public function response() {
		echo "<h1>Hello, world</h1>";
	}
}