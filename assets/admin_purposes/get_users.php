<?php 
	require_once 'assets/init.php';

	$users_per_page = 10;
	$query_us = $db->query("SELECT emailCliente FROM clientes");

	$rows = $query_us->num_rows;
	$user_pages_available = ceil($rows/$users_per_page);

	if(!isset($_GET['uPage'])) {
		$uPage = 1;
	}
	else {
		$uPage = $_GET['uPage'];
	}

	$start_uPage_result = ($uPage - 1) * $users_per_page;

	$query_u = $db->query("SELECT *
						FROM clientes
						ORDER BY emailCliente
						LIMIT $start_uPage_result, $users_per_page");

	$users = [];

	while($row = $query_u->fetch_object()) {
		$users[] = $row;
	}
 ?>