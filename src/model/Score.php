<?php
class Score {
  private $username;
  private $game;
  private $score;

  public function __construct ($username, $game, $score) {
    $this->username = $username;
    $this->game = $game;
    $this->score = $score;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getGame() {
    return $this->game;
  }

  public function getScore() {
    return $this->score;
  }

  public static function getUserScoreForGame($username, $game, $db) {

    $escapedUsername = pg_escape_string($username);
    $escapedGame = pg_escape_string($game);
    $query = "SELECT * FROM highscores WHERE username = '$escapedUsername' AND game = '$escapedGame'";
    $result = pg_query($db, $query);

    if ($row = pg_fetch_assoc($result)) {
      return new score(
        $row["username"],
        $row["game"],
        $row["score"]
      );
    }

    return null;
  }

  public static function getScoresByUsername($username, $db) {

    if (!is_string($username))

      throw new Exception("the username parameter must be a string");

    $query = "SELECT * FROM highscores WHERE username='$username'";
    $result = pg_query($db, $query);

    $scores = array();

    while ($row = pg_fetch_assoc($result)) {
      array_push(
        $scores,
      new Score(
          $row["username"],
          $row["game"],
          $row["score"]
        )
      );
    }
    return $scores;
  }

  public static function getScoresByGame($game, $db) {
    $query = "SELECT * FROM highscores WHERE game = '$game'";
    $result = pg_query($db, $query);
    $scores = array();
    while ($row = pg_fetch_assoc($result)) {
      array_push(
        $scores,
        new Score(
            $row["username"],
            $row["game"],
            $row["score"]
          )
      );
    }
    return $scores;
  }

  public static function persist($username, $game, $score, $db) {
    $escapedUsername = pg_escape_string($username);
    $escapedGame = pg_escape_string($game);
    $escapedScore = pg_escape_string($score);
    $query = "INSERT INTO highscores (username, game, score) VALUES ('$escapedUsername', '$escapedGame', '$escapedScore')";
    $result = pg_query($db, $query);
    $query = "SELECT * FROM highscores WHERE username = '$username' AND score = '$score'";
    $result = pg_query($db, $query);
    if ($result) {
      $row = pg_fetch_assoc($result);
      return new Score(
        $row["username"],
        $row["game"],
        $row["score"]
      );
    } else {
      return 'error';
    }
  }
}
