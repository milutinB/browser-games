<?php
class SigninController {

	private $request;
	private $conn;

	public function __construct( $request, $conn ) {

		$this->request = $request;
		$this->conn = $conn;

	}


	private function processRequest() {

		$username = pg_escape_string( $_POST["username"] );
		$password = hash('sha256', $_POST["password"]);
		$type = '';
		$content = '';

		$data = array( "errorMessages" => array() );

		if ( ! ( $password && $username ) ) {

			$type = 'page';

			$content = $_SERVER["DOCUMENT_ROOT"] . "/web/signin.php";

		} else {

			$q = "SELECT * FROM users WHERE username = '" . pg_escape_string( $username ) . "'";

			$user = pg_fetch_assoc(
				pg_query( $this->conn, $q )
			);

			if ( $user["password"] != $password || !$user ) {
				$type = 'page';
				$content = $_SERVER["DOCUMENT_ROOT"] . "/web/signin.php";
				array_push( $data["errorMessages"], 'Username or password is incorrect');

			} else {

				$_SESSION["user"] = $username;
				$type = 'redirect';
				$content = '/';

			}
		}
		return new Response( $content, $type, $data );
	}

	public function response() {
		return $this->processRequest();
	}
}
