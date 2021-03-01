<?php 
	require 'assets/init.php';

	$bookId = $_GET['id'];

	$comments_per_page = 5;

	$query_db = $db->query("SELECT idClassificacao, descricaoClassificacao, data_classificacao, pNomeCliente, uNomeCliente FROM classificacoes
						   INNER JOIN clientes
						   ON Clientes_emailCliente = emailCliente
						   WHERE Livros_idLivro = $bookId AND descricaoClassificacao <> ''");

	$rows = $query_db->num_rows;

	$cPagesAvailable = ceil($rows/$comments_per_page);

	if(!isset($_GET['cpage'])) {
		$cpage = 1;		
	}
	else {
		$cpage = $_GET['cpage'];
	}

	$start_cpage_result = ($cpage - 1) * $comments_per_page;

	$query_r = $db->query("SELECT idClassificacao, descricaoClassificacao, data_classificacao, pNomeCliente, uNomeCliente FROM classificacoes
						   INNER JOIN clientes
						   ON Clientes_emailCliente = emailCliente
						   WHERE Livros_idLivro = $bookId AND descricaoClassificacao <> ''
						   LIMIT $start_cpage_result, $comments_per_page");


	$reviews = [];

	while($row = $query_r->fetch_object()) {
			$reviews[] = $row;
	}
