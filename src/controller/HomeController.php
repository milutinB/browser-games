<?php
require 'AbstractController.php';

class HomeController {

	protected $request;
	
	public function __construct($request) {
		
		$this->request = $request;
		
	}

	public function response() {
		
		return "Hello!" . " Welcome to your home page";
		
	}
	
}