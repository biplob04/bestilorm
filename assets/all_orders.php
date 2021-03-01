<?php 
	require_once 'init.php';

	$email = $_SESSION['userEmail'];

	$query_orders = $db->query("
				SELECT * 
				FROM encomendas
				WHERE emailCliente = '$email' AND finalizado = 1;
			");

	$orders = [];
	$books = [];

	while($row = $query_orders->fetch_object()) {
		$orders[] = $row;
	}

	foreach ($orders as $order) {
		$query_ord_books = $db->query("
				SELECT livrosencomendas.quantidade, livros.nomeLivro, livrosencomendas.idLivro, livros.precoLivro
				FROM livrosencomendas
				INNER JOIN livros
				ON livrosencomendas.idLivro = livros.idLivro
				WHERE idEncomenda = $order->idEncomenda; 
			");

		while($row = $query_ord_books->fetch_object()) {
			$books[$order->idEncomenda][] = $row;
		} 	
	}
 ?>