<?php
error_reporting(E_ALL);
$conn = pg_connect(getenv('DATABASE_URL'));

$q = "DROP TABLE users;";

if (pg_query($conn, $q)) {
	echo "Table deleted!";
};

$q = "CREATE TABLE users (id serial PRIMARY KEY, email varchar(40), username varchar(40), password varchar(100));";

if (pg_query($conn, $q)) {
	
	echo "Table created!";
	
}

$q = "INSERT INTO users (email, username, password) VALUES ('bob@bob.com', 'bobsusername', 'bobspassword');";

pg_query($conn, $q);

$q = "INSERT INTO users (email, username, password) VALUES ('alice@alice.com', 'alicessusername', 'alicesspassword');";

pg_query($conn, $q);

$q = "SELECT * FROM users;";

$result = pg_query($conn, $q);

while ($row = pg_fetch_assoc($result)) {
	echo $row["username"];
	echo $row["id"];
}

