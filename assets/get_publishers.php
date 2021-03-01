<?php 
	require_once 'init.php';

	$query_pub = $db->query("
					SELECT idEditora, nomeEditora
					FROM editoras
					ORDER BY nomeEditora
		");

	$publishers = [];

	while($row = $query_pub->fetch_object())
		$publishers[] = $row;
