<?php

class LogoutController {

	public function __construct( ) {
		
		
	}
	
	public function response() {
		
		return new Response('', 'logout', array());
		
	}
}