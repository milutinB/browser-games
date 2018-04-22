<?php
class Controller {
	
	protected function setRequest($request) {
		
		$this->request = $request;
		
	}
	
	public function __construct($request) {
		
		$this->request = $request;
		
	}
}