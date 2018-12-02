<?php
include_once('./src/model/User.php');

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
		$user = User::getUserByUsername($username, $this->conn);
		$data = array("errorMessages" => array());
		if (!($password && $username && $user instanceof User)) {
			$type = 'page';
			$content = $_SERVER["DOCUMENT_ROOT"] . "/web/signin.php";
		} else {
			//$user = User::getUserByUsername($username, $this->conn);
			if ($password != $user->getPassword()) {
				$type = 'page';
				$content = $_SERVER["DOCUMENT_ROOT"] . "/web/signin.php";
				array_push($data["errorMessages"], "Username or password is incorrect");
			} else {
				$_SESSION["user"] = $username;
				$type = "redirect";
				$content = '/';
			}

		}
		return new Response($content, $type, $data);
	}

	public function response() {
		return $this->processRequest();
	}
}
