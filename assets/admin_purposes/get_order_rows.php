<?php 
	require_once 'assets/init.php';
	$total_orders = $db->query("
			SELECT idEncomenda
			FROM encomendas
			WHERE finalizado = 1 
		")->num_rows;
?>
