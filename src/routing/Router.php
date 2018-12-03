<?php
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/Request.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/Response.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/HomeController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/SignupController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/TestController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/LogoutController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/SigninController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/AsteroidsController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/GameoverController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/GamesController.php';
require $_SERVER["DOCUMENT_ROOT"].'/src/controller/LeaderboardController.php';

error_reporting(E_ALL);


class Router {

	private $request;
	private $conn;


	public function __construct( $request ) {

		$this->request = $request;

		$this->conn = pg_connect( getenv("DATABASE_URL") );

	}

	private function passToController() {

		$url = $this->request->getUrl();

		//$controller = new AsteroidsController( $this->request, $this->conn );

		$controller = null;

		if ($url == "/") {

			$controller = new HomeController($this->request);

		}
		else if ($url == "/signup") {

			$controller = new SignupController($this->request, $this->conn);

		} else if ($url == '/signin') {

			$controller = new SigninController( $this->request, $this->conn );

		} else if ($url == "/test") {

			$controller = new TestController($this->request);

		} else if ($url == "/logout") {

			$controller = new LogoutController();

		} else if ($url == "/games") {

			$controller = new GamesController( $this->request );

		} else if ($url == "/games/asteroids") {

			$controller = new AsteroidsController( $this->request, $this->conn );

		} else if ($url == '/gameover') {

			$controller = new GameoverController ( $this->request, $this->conn );

		} else if ($url == '/leaderboards') {

			$controller = new LeaderboardController ( $this->request, $this->conn );

		}

		if ($controller != null) {

			return $controller->response();

		} else {

			$page = $_SERVER['DOCUMENT_ROOT'] . "/web/pagenotfound.php";

			return new Response( $page, 'page', array() );

		}


	}

	public function response() {
		return $this->passToController();
	}


}
