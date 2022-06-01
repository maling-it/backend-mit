<?php

require __DIR__."/../init.php";

function main(): int
{
	$http_code = 200;
	$where = "";
	$offset = 0;
	$limit = 30;
	$res = [];
	$data = [];

	if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
		$limit = (int)$_GET["limit"];
		if ($limit > 300)
			$limit = 300;
		else if ($limit < 0)
			$limit = 0;
	}

	if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
		$offset = (int)$_GET["offset"];
		if ($offset < 0)
			$offset = 0;
	}

	if (isset($_GET["search_name"]) && is_string($_GET["search_name"])) {
		$where = "WHERE name LIKE ?";
		$data = ["%{$_GET["search_name"]}%"];
	}

	if (isset($_GET["search_id"]) && is_string($_GET["search_id"])) {
		$where = "WHERE id = ?";
		$data = [$_GET["search_id"]];
	}

	$pdo = get_pdo();
	$st = $pdo->prepare("SELECT COUNT(1) FROM pdf {$where}");
	$st->execute($data);
	$nr = $st->fetch(PDO::FETCH_NUM);

	$st = $pdo->prepare("SELECT id, gd_id, name, size FROM pdf {$where} LIMIT {$limit} OFFSET {$offset}");
	$st->execute($data);
	$res = [
		"num_rows" => (int)$nr[0],
		"data" => $st->fetchAll(PDO::FETCH_ASSOC)
	];

out:
	http_response_code($http_code);
	header("Content-Type: application/json");
	echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES |
			 JSON_UNESCAPED_UNICODE);
	return 0;
}

exit(main());
