<?php
class SignupController {
	
	private $request;
	private $conn;
	
	
	public function __construct( $request, $conn ) {
		
		$this->request = $request;
		
		$this->conn = $conn;
		
	}
	
	
	private function isValidEmail( $email ) {
		
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
		
	}
	
	private function isValidUsername( $username ) {
		
		return sizeof( explode(" ", $username) ) == 1;
		
	}
	
	
	private function processRequest() {
		
		//return "Hello, new user";
		
		$post = $this->request->getPost();
		
		$session = $_SESSION;
		
		$response = "";
		
		$email = $post["email"];
		$password = hash('sha256', $post["password"]);
		$repeatPassword = hash('sha256', $post["repeatPassword"]);
		$username = $post["username"];
		$errorMessages = array();
		
		if (! ($email && 
			   $password && 
				$repeatPassword && 
				$username)) {
			
			//$response = "Ha";
			
			$type = 'page';
			
			$page = $_SERVER["DOCUMENT_ROOT"] . "/web/signup.php";
			
			$data = array();
			
			array_push($data, array(
				"errorMessages" => $errorMessages
			));
			
			$response = new Response( $page, $type, $data );
			
		}
		else {
			
			//$response = $email . ", " . $username . ", " . $password;
			
			
			$q = "SELECT * FROM users WHERE email = '" . pg_escape_string( $email ) . "'";

			if ( pg_fetch_assoc( pg_query( $this->conn, $q ) ) ) {
				
				array_push( $errorMessages, "Email is already registered");
				
			} 

			$q = "SELECT * FROM users WHERE username = '" . pg_escape_string( $username ) . "'";

			if ( pg_fetch_assoc( pg_query( $this->conn, $q ) ) ) {
				
				array_push( $errorMessages, "Username is already in use" );
				
			}		
			
			if ( !$this->isValidEmail( $email ) ) {
				
				array_push( $errorMessages, "Invalid email address." );
				
			}
			
			if ( !$this->isValidUsername( $username ) ) {
				
				array_push($errorMessages, "Username cannot contain spaces");
				
			}	
			
			if ( $password != $repeatPassword ) {
				
				array_push( $errorMessages, "Passwords do not match." );
				
			}
			
			if ( sizeof( $errorMessages ) == 0 ) {
				
				$q = "INSERT INTO users VALUES ('" . pg_escape_string( $username ) . "', '" . pg_escape_string( $email ) . "', '" . $password ."' )";
				
				if ( pg_query ( $this->conn, $q ) ) {
					
					$_SESSION["user"] = $username;
					//$response = "success!";
					
					//$response = $_SERVER["DOCUMENT_ROOT"] . "/web/home.html" . $session["user"];
					
					$url = "/";
					
					$type = 'redirect';
					
					$data = array();
					
					$response = new Response($url, $type, $data);
					
				} else {
					
					//$response = "Error: "; //. //pg_last_error($conn);
					
					array_push( $errorMessages, "Error: Unable to create account");
					
					
					
					$data = array(
						"errorMessages"=>$errorMessages
					);
										
					$type = 'page';
					
					$page = $_SERVER["DOCUMENT_ROOT"] . "/web/signup.php";
					
					$response = new Response( $page, $type, $data );
					
				}
				
				
			} else {
				
				$type = 'page';
				
				$page = $_SERVER["DOCUMENT_ROOT"] . "/web/signup.php";
				
				$data = array(
						"errorMessages"=>$errorMessages
					);
				
				$response = new Response( $page, $type, $data );
				
				
				
				
				
			}
			
		}
		
		
		return $response;
		
	}
	
	
	public function response() {
		
		return $this->processRequest();
		
	}
	
	
}