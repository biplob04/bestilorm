<?php 
	require_once 'init.php';

	$query_lb = $db->query("
			SELECT nomeLivro, dataAdicionada, nomeAutor, imagemLivro, precoLivro, idLivro
			FROM livros
			INNER JOIN autores
			ON livros.idAutor = autores.idAutor 
			ORDER BY dataAdicionada DESC
			LIMIT 10
		");

	$lat_books = [];

	while($row = $query_lb->fetch_object()) {
		$lat_books[] = $row;
	}

	list($lat_books1, $lat_books2) = array_chunk($lat_books, ceil(count($lat_books) / 2));

