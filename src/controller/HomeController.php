<?php
require 'AbstractController.php';

class HomeController {

	protected $request;
	
	public function __construct($request) {
		
		$this->request = $request;
		
	}

	public function response() {
		
		$page = $_SERVER["DOCUMENT_ROOT"] . "/web/home.php";
		
		//$data = array(
			//"user" => $this->request
		//				   ->getPost()["user"]
		//);
		
		return new Response( $page , "page", array() );
		
	}
	
}