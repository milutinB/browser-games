<?php

$db = pg_connect( getenv( 'DATABASE_URL' ) );


$q = "CREATE TABLE highscores ( username varchar( 40 ), game varchar(40), score integer )";

if ( pg_query( $db, $q ) ) {
	
	echo "table created :)";
	
} 