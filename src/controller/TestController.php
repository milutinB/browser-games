<?php

class TestController {
	
	private $request;
	
	public function __construct( $request ) {
		
		$this->request = $request;
		
	}
	
	public function response( ) {
		
		$data = array( "name" => "bob" );
		
		return new Response($_SERVER["DOCUMENT_ROOT"] . "\web/test.php", 'page', $data);
		
	}
	
}