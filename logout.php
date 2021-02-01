<?php
	session_destroy();
	echo 'LOGOUT';
	header( "refresh:1; url=index.php" );
?>