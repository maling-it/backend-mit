<?php

require __DIR__."/cred.php";

$pdo = new PDO("mysql:host=localhost;dbname=maling_it", $user, $pass,
	       [
	       		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	       ]);


$st = $pdo->prepare("INSERT INTO `pdf` (`gd_id`, `name`, `size`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, NULL);");
$j = json_decode(file_get_contents(__DIR__."/mal.json"), true);
foreach ($j as $x) {
	$st->execute([
		$x["id"],
		$x["name"],
		(int)$x["size"],
		date("Y-m-d H:i:s")
	]);
}
