<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('./src/model/Score.php');

final class ScoreTest extends TestCase {

  public function testPersist() {
    $db = pg_connect(getenv('DATABASE_URL'));
    $query = "DELETE FROM highscores WHERE username = 'test_user'";
    pg_query($db, $query);

    $username = "test_user";
    $game = "asteroids";
    $score = 10;
    $score = Score::persist($username, $game, $score, $db);

    $this->assertTrue(
      $score instanceof Score
    );

    $query = "DELETE FROM highscores WHERE username = 'test_user'";
    pg_query($db, $query);
  }

  public function testGetUserScoreForGame() {
    $db = pg_connect(getenv('DATABASE_URL'));
    $username = 'test_user';
    $game = "Dark Souls 4";
    $scoreValue = 1000;
    $query = "DELETE FROM highscores WHERE username = '$username'";
    pg_query($db, $query);

    $query = "INSERT INTO highscores (username, game, score) VALUES ('$username', '$game', '$scoreValue')";
    pg_query($db, $query);

    $score = Score::getUserScoreForGame($username, $game, $db);
    $this->assertTrue(
      $score instanceof Score
    );
    $this->assertEquals(
      $score->getUsername(), $username
    );
    $this->assertEquals(
      $score->getGame(), $game
    );
    $this->assertEquals(
      $score->getScore(), $scoreValue
    );

    $query = "DELETE FROM highscores WHERE username = '$username'";
    pg_query($db, $query);

    $score = Score::getUserScoreForGame($username, $game, $db);

    $this->assertNull(
        $score
      );
  }

  public function testGetScoresByGame() {

    $db = pg_connect(getenv('DATABASE_URL'));

    $fakeUsers = array(
                  "A" => 1,
                  "B" => 2,
                  "C" => 3,
                  "D" => 4,
                  "E" => 5,
                  "F" => 6,
                  "G" => 7
                );

    $fakeGame = "Dark Souls 4";
    $query = "DELETE FROM highscores WHERE game = '$fakeGame'";

    pg_query($db, $query);
    foreach($fakeUsers as $username => $score) {
      $query = "DELETE FROM highscores WHERE username = '$username'";
      pg_query($db, $query);
      $query = "INSERT INTO highscores (username, game, score) VALUES ('$username', '$fakeGame', '$score')";
      pg_query($db, $query);
    }

    $scores = Score::getScoresByGame($fakeGame, $db);

    $this->assertEquals(
      sizeof($scores), 7,
      "There should be a score object for each user"
    );

    foreach($scores as $score) {
      $username = $score->getUsername();
      $scoreValue = $score->getScore();
      $this->assertEquals(
        $fakeUsers[$username], $scoreValue,
        "The usernames should be matched with the same scores"
      );
    }

    $query = "DELETE FROM highscores WHERE game = '$fakeGame'";
    pg_query($db, $query);

  }

}
