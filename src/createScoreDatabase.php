<?php

$db = pg_connect(getenv('DATABASE_URL'));
$query = "CREATE TABLE highscores (username varchar(40), game varchar(40), score int)";
$result = pg_query($db, $query);


if ($result) {
  echo "success";
} else {
  echo "oops";
}
