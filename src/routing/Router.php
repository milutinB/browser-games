<?php
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/Request.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/HomeController.php';
error_reporting(E_ALL);


class Router {
	
	private $request;
	
	public function __construct($request) {
		
		$this->request = $request;
		
	}
	
	private function passToController() {
		
		$url = $this->request->getUrl();
		
		$controller = null;
		
		if ($url == "/home") {
	
			$controller = new HomeController($this->request);
			
		}

		if ($controller != null) {	
		
			return $controller->response();
			
		}
		else {
			
			return "Sorry, that page doesn't exist.";
			
		}
	}
	
	public function response() {
		
		return $this->passToController();
		
	}
	
	
}