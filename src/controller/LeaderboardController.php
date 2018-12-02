<?php
class LeaderboardController {
	private $request;
	private $conn;

	public function __construct ($request, $conn) {
		$this->request = $request;
		$this->conn = $conn;
	}


	private function fetchScores($game) {
		$conn = $this->conn;
		$q = "SELECT * FROM highscores WHERE game = '" . pg_escape_string( $game ) . "' ORDER BY score DESC LIMIT 10";
		$result = pg_query($conn, $q);
		$scores = array();
		while ($row = pg_fetch_assoc($result)) {
			array_push($scores, $row);
		}
		return $scores;
	}

	public function response() {
		$type = 'page';
		$content = $_SERVER['DOCUMENT_ROOT'] . "/web/leaderboards.php";
		$data = $this->fetchScores( 'asteroids' );
		return new Response( $content, $type, $data );
	}
}
