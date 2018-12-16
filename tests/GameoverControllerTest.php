<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('./src/controller/Request.php');
include_once('./src/controller/Response.php');
include_once('./src/controller/GameoverController.php');

final class GameoverControllerTest extends TestCase {
  public function testResponse() {
      $db = pg_connect(getenv('DATABASE_URL'));
      $username = 'test_user';
      $email = "testblah@email.com";
      $password = "password";
      $game = "Dark Souls 4";
      $scoreValue = 10;
      $query = "DELETE FROM users WHERE username = '$username'";
      pg_query($db, $query);
      $query = "DELETE FROM highscores WHERE username = '$username'";
      pg_query($db, $query);

      $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
      pg_query($db, $query);
      $query = "INSERT INTO highscores (username, game, score) VALUES ('$username', '$game', '$scoreValue')";
      pg_query($db, $query);

      $_SESSION["user"] = $username;

      $post = array(
        "game" => "Dark Souls 4",
        "score" => 10000
      );
      $get = array();
      $requestUri = "/gameover";
      $request = new Request($get, $post, $requestUri);
      $controller = new GameoverController($request, $db);
      $response = $controller->response();
      $this->assertTrue(
        $response instanceof Response
      );
      $data = $response->getData();
      $this->assertEquals(
        10000, $data["score"]
      );
      $this->assertEquals(
        $response->getType(), 'json'
      );
      $scoreValue = 10;
      $query = "DELETE FROM users WHERE username = '$username'";
      pg_query($db, $query);
      $query = "DELETE FROM highscores WHERE username = '$username'";
      pg_query($db, $query);
  }
}
