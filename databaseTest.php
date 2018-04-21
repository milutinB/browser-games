<?php
error_reporting(E_ALL);

$conn = pg_connect(getenv("DATABASE_URL"));


$q = "DROP TABLE test_table;";

pg_query($conn, $q);

$q = "CREATE TABLE test_table (field varchar(40));";


pg_query($conn, $q);
	
$q = "INSERT INTO test_table VALUES ('test data');";

pg_query($conn, $q);

$q = "SELECT * FROM test_table;";

$result = pg_query($conn, $q);

while ($row = pg_fetch_assoc($result)) {
	echo $row["field"];
}

$q = "DROP TABLE test_table;";

pg_query($conn, $q);