<?php
class Request {
	
	private $get;
	private $post;
	private $requestURL;
	
	public function __construct( $get, $post, $requestURL ) {
		
		$this->get = $get;
		
		$this->post = $post;
		
		$this->requestURL = $requestURL;

	}

	
	public function getGet() {
		
		return $this->get;
		
	}
	
	public function getPost() {
		
		return $this->post;
		
	}
	
	public function getUrl() {
		
		return $this->requestURL;
		
	}
	
	
}