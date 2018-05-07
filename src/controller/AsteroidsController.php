<?php

class AsteroidsController {
	
	private $request;
	private $conn;
	
	public function __construct( $request, $conn ) {
		
		$this->request = $request;
		$this->conn = $conn;
		
	}
	
	
	public function response() {
		
		$db = $this->conn;
		
		$user = $_SESSION['user'];
		
		$data = array();
		
		if ( !$user ) {
			
			$data["scoreMessage"] = "Login or sign up to save your highscore!";

			
		} else {
		
			$q = "SELECT * FROM highscores WHERE game='asteroids' AND username = '" . pg_escape_string( $user ) . "'";
			
			$result = pg_query( $db, $q );
			
			$row = pg_fetch_assoc( $result );
			
			if ( !$row ) {
			
				$data["scoreMessage"] = "You haven't played this game yet.";
				
			} else {
				
				$score = $row["score"];
				
				
				$data["scoreMessage"] = "Your highest score is ". pg_escape_string( $score ) . ".";
				
			}
			
		}
		
		$type = 'page';
		
		$content = $_SERVER["DOCUMENT_ROOT"] . "/web/asteroids.php";
		
		
		return new Response( $content, $type, $data );
		
	}
	
	
}