<?php
include_once('./src/model/User.php');
$db = pg_connect(getenv('DATABASE_URL'));
$query = "DELETE FROM users";
$result = pg_query($db, $query);

$email = "bob@email.com";
$username = "bob";
$password = "securepassword";
$user = User::persist($email, $username, $password, $db);
echo "hello";
echo $user->getUsername();
