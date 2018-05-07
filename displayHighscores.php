<?php

$db = pg_connect( getenv( 'DATABASE_URL' ) );

$q = "SELECT * FROM highscores";

$result = pg_query( $db, $q );

while ( $row = pg_fetch_assoc( $result ) ) {
	
	echo json_encode( $row );
	
} 