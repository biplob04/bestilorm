<?php 
	require_once 'assets/init.php';

	$orders_per_page = 10;
	$query_or = $db->query("SELECT idEncomenda FROM encomendas WHERE finalizado = 1");

	$rows = $query_or->num_rows;
	$order_pages_available = ceil($rows/$orders_per_page);

	if(!isset($_GET['oPage'])) {
		$oPage = 1;
	}
	else {
		$oPage = $_GET['oPage'];
	}

	$start_oPage_result = ($oPage - 1) * $orders_per_page;

	$query_o = $db->query("SELECT *
						FROM encomendas
						WHERE finalizado = 1
						LIMIT $start_oPage_result, $orders_per_page");

	$orders = [];

	while($row = $query_o->fetch_object()) {
		$orders[] = $row;
	}
 ?>