<?php 
	require_once 'assets/init.php';

	$books_per_page = 10;
	$query_bt = $db->query("SELECT idLivro FROM livros");

	$rows = $query_bt->num_rows;
	$book_pages_available = ceil($rows/$books_per_page);

	if(!isset($_GET['bpage'])) {
		$bpage = 1;
	}
	else {
		$bpage = $_GET['bpage'];
	}

	$start_bpage_result = ($bpage - 1) * $books_per_page;

	$query_b = $db->query("SELECT *
						FROM livros
						INNER JOIN temas
						ON livros.idTema=temas.idTema
						INNER JOIN autores
						ON livros.idAutor=autores.idAutor
						INNER JOIN editoras
						ON livros.idEditora=editoras.idEditora
						ORDER BY idLivro
						LIMIT $start_bpage_result, $books_per_page");

	$books = [];

	while($row = $query_b->fetch_object()) {
		$books[] = $row;
	}
 ?>