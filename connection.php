<?php 

// $server = 'localhost';
// $username = 'simaqxlt_oceanfortune_db';
// $password = 'oceanfortune_db';
// $db = 'simaqxlt_oceanfortune_db';

$server = 'localhost';
$username = 'root';
$password = '';
$db = 'simaqxlt_oceanfortune_db';



	$conn = mysqli_connect($server, $username, $password, $db);

	if (!$conn) {
		die('connection error!');
	}
 

 ?>