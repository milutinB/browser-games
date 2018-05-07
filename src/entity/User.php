<?php

class User {
	
	private $email;
	private $username;
	private $password;
	private $db;
	
	
	public function __construct( $email, $username, $password, $db ) {
		
		$this->email = pg_escape_string( $email );
		
		$this->username = pg_escape_string( $username );
		
		$this->password = pg_escape_string( $password );
		
		$this->db = $db;
		
	}
	
	
	public function __construct( ) {
		
		
		
	}
	
	public function query( $username, $passwsord ) {
		
		$u = pg_escape_string( $username );
		$p = pg_escape_string( $password );
		
		$q = "SELECT * FROM users WHERE username = '" . $u . "' AND " . 
										"password = '" . $p . "'";
		
		$result = pg_query( $this->db, $q);
		
		$row = pg_fetch_assoc( $result );
		
		if ( $row ) {
			
			$this->email = $row["email"];
			
			$this->username = $row["username"];
			
			$this->password = $row["password"];
			
			return TRUE;
			
		} else {
			
			return FALSE;
			
		}
		
	}
	
	public function persist() {
		
		$q = "INSERT INTO users ( email, usernmae, password )" .
		 "VALUES ( '" . $this->email  . "', " . 
				 " '" . $this->username  . "', ".
				 " '" . $this->password  . " ' " .
		 " )";
		 
		return pg_query( $this->db, $q ); 
		
	}
	
	public function delete() {
		
		$q = "DELETE FROM users WHERE ".
		   "email = '" . $this->email  . "' AND " . 
		"username = '" . $this->username . "' AND " . 
		"password = '" . $this->password . "'";
		
		return pg_query( $this->db, $q );
		
	}
	
}