<?php 
	session_start();
	require_once '../init.php';
	$email = $_GET['email'];

	if($result = $db->query("SELECT emailCliente FROM clientes WHERE emailCliente = '$email'")) {
		$row_cnt = $result->num_rows;

		if($row_cnt < 1) {
			header("Location: ../../admin.php?user=noE&email=$email");
			die();
		} 
	}

	$query_e = $db->query("SELECT idEncomenda FROM encomendas WHERE emailCliente = '$email'");

	$enc = [];

	while($row = $query_e->fetch_object()) {
		$enc[] = $row;
	} 	

	for ($i=0; $i < sizeof($enc); $i++) { 
		$idE = $enc[$i]->idEncomenda;
		$db->query("DELETE FROM livrosencomendas WHERE idEncomenda = $idE");
	}

	$db->query("DELETE FROM encomendas WHERE emailCliente = '$email'");
	$db->query("DELETE FROM classificacoes WHERE Clientes_emailCliente = '$email'");
	$db->query("DELETE FROM clientes WHERE emailCliente = '$email'");

	if($email == $_SESSION['userEmail']) {
		header("Location: ../logout.php");
		die();
	}

	header("Location: ../../admin-user.php?user=deleted");
	die();
 ?>