<?php 
	require_once 'init.php';

	$query_aut = $db->query("
					SELECT idAutor, nomeAutor
					FROM autores
					ORDER BY nomeAutor
		");

	$authors = [];

	while($row = $query_aut->fetch_object())
		$authors[] = $row;
