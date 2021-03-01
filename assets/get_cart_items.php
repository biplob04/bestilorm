<?php 
	require 'init.php';

	$email = $_SESSION['userEmail'];
	$query_idEnc = $db->query("
				SELECT idEncomenda 
				FROM encomendas 
				WHERE (emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL))")->fetch_object();
	
	if($query_idEnc) {
		$idEnc = $query_idEnc->idEncomenda; # This is the encomenda's id

		$query_EncLiv = $db->query("
					SELECT livrosencomendas.idLivro, livrosencomendas.quantidade, livros.nomeLivro, livros.imagemLivro, livros.precoLivro
					FROM livrosencomendas
					INNER JOIN livros
					ON livrosencomendas.idLivro = livros.idLivro
					WHERE idEncomenda = $idEnc
			");

		$query_precoFinal = $db->query("
					SELECT SUM(livrosencomendas.quantidade * livros.precoLivro) AS preco
					FROM livrosencomendas
					INNER JOIN livros
					ON livrosencomendas.idLivro = livros.idLivro
					WHERE idEncomenda = $idEnc
			");

		$precoFinal = $query_precoFinal->fetch_object()->preco;

		$books = [];
		$out_of_stock_books = [];

		while($row = $query_EncLiv->fetch_object()) {
			$id_book = $row->idLivro;
			$get_book_stock = $db->query("SELECT stockLivro FROM livros WHERE idLivro = $id_book")->fetch_object()->stockLivro;

			$remaining_stock = $get_book_stock - $row->quantidade;

			if($remaining_stock < 0) {
				$db->query("DELETE FROM livrosencomendas WHERE idLivro = $id_book AND idEncomenda = $idEnc");
				$out_of_stock_books[] = $row;
			}
			else 
				$books[] = $row;
		}
	}
	else {
		$books = [];
		$query_EncLiv = false;
	}
	
 ?>