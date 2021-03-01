<?php 
	require_once 'init.php';

	$query = $db->query("SELECT idTema, tema FROM temas ORDER BY tema");
	$genres = [];

	while($row = $query->fetch_object()) {
		$genres[] = $row;
	}
