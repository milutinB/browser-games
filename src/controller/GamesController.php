<?php

class GamesController {
	
	private $request;
	
	public function __construct( $request ) {
		
		$this->request = $request;
		
	}
	
	public function response() {
		
		$type = 'page';
		$data = array();
		$content = $_SERVER['DOCUMENT_ROOT'] . "/web/games.php";
		
		return new Response( $content, $type, $data );
		
	}
	
}