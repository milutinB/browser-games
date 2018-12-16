<?php
include_once('./src/model/User.php');

class SignupController {

	private $request;
	private $conn;

	public function __construct($request, $conn) {
		$this->request = $request;
		$this->conn = $conn;
	}


	private function processRequest() {
		$response = "";
		$errorMessages = array();
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$repeatPassword = $_POST["repeatPassword"];

		if (!($email && $password && $repeatPassword && $username)) {
			array_push($errorMessages, "All fields must be completed");
			$type = 'page';
			$page = $_SERVER["DOCUMENT_ROOT"] . "/web/signup.php";
			$data = array();
			$data["errorMessages"] = $errorMessages;
			$response = new Response($page, $type, $data);
		}
		else {

			$user = array();

			if ($password == $repeatPassword) {
				$user = User::persist($email, $username, $password, $this->conn);
		  } else {
				//Report relevant error messages if the passwords don't match
				array_push(
					$errorMessages,
					"Passwords don't match"
				);
			}

			if (!$user instanceof User) {
				//Report relevant error messages if the persist method failed
					$messages = $user;
					foreach ($messages as $message) {
						array_push(
							$errorMessages,
							$message
						);
					}

				$type = 'page';
				$page = $_SERVER["DOCUMENT_ROOT"] . "/web/signup.php";
				$data = array("errorMessages" => $errorMessages);
				$response = new Response($page, $type, $data);
			} else {
				$_SESSION["user"] = $username;
				$url = "/";
				$type = 'redirect';
				$data = array();
				$response = new Response($url, $type, $data);
			}
		}
		return $response;
	}
	public function response() {
		return $this->processRequest();
	}
}
