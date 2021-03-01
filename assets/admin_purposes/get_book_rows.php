<?php 
	require_once 'assets/init.php';
	$total_books = $db->query("
			SELECT idLivro 
			FROM livros 
		")->num_rows;
?>