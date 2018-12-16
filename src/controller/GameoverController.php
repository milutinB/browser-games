<?php
include_once("./src/model/Score.php");
class GameoverController {

	private $request;
	private $conn;

	public function __construct( $request, $conn ) {
		$this->request = $request;
		$this->conn = $conn;
	}


	private function processRequest() {

		if ( !$_SESSION['user'] ) {
			die();
		}
		$request = $this->request;
		$db = $this->conn;
		$post = $request->getPost();
		$user = $_SESSION["user"];
		$game = $post["game"];
		$score = $post["score"];

		$type = 'json';
		$content = '';
		$data = array();

		$prevScore = Score::getUserScoreForGame($user, $game, $db);

		if ($prevScore) {
			$prevScore = $prevScore->getScore();
		} else {
			$prevScore = 0;
		}


		if ($score > $prevScore) {
			$s = Score::persist($user, $game, $score, $db);
			$data["score"] = $s->getScore();
		}


/*
		$q = "SELECT * FROM highscores WHERE username = '" . pg_escape_string( $user ). "' AND  game = '" . pg_escape_string( $game ) . "'";

		if ( $row = pg_fetch_assoc( pg_query( $db, $q ) ) ) {

			if ( $row["score"] < $score ) {

				$q = "DELETE FROM highscores WHERE username = '" . pg_escape_string( $user ) . "' AND game = '" . pg_escape_string( $game ) ."'";
				pg_query( $db, $q );

				$q = "INSERT INTO highscores VALUES ( '" . pg_escape_string( $user ) . "', '" . pg_escape_string( $game ) . "', '" . pg_escape_string( $score ) . "')";
				pg_query( $db, $q );

				$data["score"] = $score;

			}

		} else {

			$q = "INSERT INTO highscores VALUES ( '" . pg_escape_string( $user ) . "', '" . pg_escape_string( $game ) . "', '" . pg_escape_string( $score ) . "')";
			pg_query( $db, $q );

		}*/

		return new Response( $content, $type, $data );

	}

	public function response() {

		return $this->processRequest();

	}

}
