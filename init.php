<?php

require __DIR__."/cred.php";

function get_pdo(): PDO
{
	return new PDO(
		"mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,
		DB_USER,
		DB_PASS,
		[
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	);
}
