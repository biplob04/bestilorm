<?php 
	# Value 0 = Show all books, 1 = Show all books (specified genre), 2 = Show searched books (specified genre)
	$showBooks = 0; 

	# How many results do I want per page?
	$results_per_page = 12;

	# Number of results stored in database (compatible with search and genre)
	if(isset($_GET['genre']) && isset($_GET['search'])) {  # If user searches for a book and specifies its genre 
		$userGenre = $_GET['genre'];
		$userSearch = $_GET['search'];
		$showBooks = 2;

		if($userGenre == 'all-cat') { # If genre doesn't matter (All genres)
			$results_db = $db->query("SELECT livros.nomeLivro, temas.tema
							          FROM livros
							          INNER JOIN temas
							          ON livros.idTema=temas.idTema
							          WHERE nomeLivro LIKE '%$userSearch%'");
		}
		else { # IF genre matters
			$results_db = $db->query("SELECT livros.nomeLivro, temas.tema
							          FROM livros
							          INNER JOIN temas
							          ON livros.idTema=temas.idTema
							           WHERE (temas.tema = '$userGenre' AND nomeLivro LIKE '%$userSearch%')");
		}
	}
	elseif(isset($_GET['genre'])) {  # If user uses Livro's dropdown menu and click on a genre
		$showBooks = 1;
		$userGenre = $_GET['genre'];
		$results_db = $db->query("SELECT livros.nomeLivro, temas.tema
							      FROM livros
							      INNER JOIN temas
							      ON livros.idTema=temas.idTema
							      WHERE temas.tema = '$userGenre'");
	}
	else {  # If user clicks on Livro (navigation)
		$results_db = $db->query("SELECT livros.nomeLivro, temas.tema
							      FROM livros
							      INNER JOIN temas
							      ON livros.idTema=temas.idTema");
	}
	
	$rows = $results_db->num_rows;

	# Number of pages available 
	$pages_available = ceil($rows/$results_per_page);

	# Which number of page is user currently in?
	if(!isset($_GET['page'])) {
		$page = 1;
	}
	else {
		$page = $_GET['page'];
	}

	# Starting_result = (Page_number - 1) * Results_per_page; 
	$start_page_result = ($page - 1) * $results_per_page;

	# Using SQL LIMIT for the results on the displaying page
	# Get books stored in the database, either by search, by genre or just show them all.
	if($showBooks == 2) {
		$userGenre = $_GET['genre'];
		$userSearch = $_GET['search'];

		if($userGenre == 'all-cat') {
			$query_b = $db->query("SELECT livros.idLivro, livros.nomeLivro, CEIL(livros.precoLivro) AS precoLivro, livros.imagemLivro, autores.nomeAutor, temas.tema
							   FROM livros
							   INNER JOIN temas
							   ON livros.idTema=temas.idTema
							   INNER JOIN autores
							   ON livros.idAutor=autores.idAutor
							   WHERE nomeLivro LIKE '%$userSearch%'
							   ORDER BY nomeLivro
							   LIMIT $start_page_result, $results_per_page");
		}
		else {
			$query_b = $db->query("SELECT livros.idLivro, livros.nomeLivro, CEIL(livros.precoLivro) AS precoLivro, livros.imagemLivro, autores.nomeAutor, temas.tema
							   FROM livros
							   INNER JOIN temas
							   ON livros.idTema=temas.idTema
							   INNER JOIN autores
							   ON livros.idAutor=autores.idAutor
							   WHERE (temas.tema = '$userGenre' AND nomeLivro LIKE '%$userSearch%')
							   ORDER BY nomeLivro
							   LIMIT $start_page_result, $results_per_page");
		}
		
	}
	elseif($showBooks == 1) {
		$userGenre = $_GET['genre'];

		$query_b = $db->query("SELECT livros.idLivro, livros.nomeLivro, CEIL(livros.precoLivro) AS precoLivro, livros.imagemLivro, autores.nomeAutor, temas.tema
							   FROM livros
							   INNER JOIN temas
							   ON livros.idTema=temas.idTema
							   INNER JOIN autores
							   ON livros.idAutor=autores.idAutor
							   WHERE temas.tema = '$userGenre'
							   ORDER BY nomeLivro
							   LIMIT $start_page_result, $results_per_page");
	}
	elseif($showBooks == 0) {
		$query_b = $db->query("SELECT livros.idLivro, livros.nomeLivro, CEIL(livros.precoLivro) AS precoLivro, livros.imagemLivro, autores.nomeAutor, temas.tema
							   FROM livros
							   INNER JOIN temas
							   ON livros.idTema=temas.idTema
							   INNER JOIN autores
							   ON livros.idAutor=autores.idAutor
							   ORDER BY nomeLivro
							   LIMIT $start_page_result, $results_per_page");
	}


	$books = [];

	while($row = $query_b->fetch_object()) {
		$books[] = $row;
	}