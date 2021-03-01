<?php 
	require_once 'assets/init.php';
	$total_users = $db->query("
			SELECT emailCliente 
			FROM clientes 
		")->num_rows;
?>