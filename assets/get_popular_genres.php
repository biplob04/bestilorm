<?php 
	require_once 'init.php';

	$query_enc = $db->query("
			SELECT idEncomenda 
			FROM encomendas 
			WHERE finalizado = 1;
		");

	$idsE = [];

	while($row = $query_enc->fetch_object()) {
		$idsE[] = $row;
	}

	$idsL = [];

	for ($i=0; $i < sizeof($idsE); $i++) { 
		$id = $idsE[$i]->idEncomenda;

		$query_liv = $db->query("
				SELECT idLivro 
				FROM livrosencomendas 
				WHERE idEncomenda = $id;
			");

		while($row = $query_liv->fetch_object()) {
			$idsL[] = $row;
		}
	}

	$all_genres_name = [];
	$all_genres_image = [];

	for ($i=0; $i < sizeof($idsL); $i++) { 
		$id = $idsL[$i]->idLivro;

		$query_genre = $db->query("
				SELECT tema, imagemTema
				FROM livros
				INNER JOIN temas
				ON livros.idTema = temas.idTema
				WHERE idLivro = $id;
			");

		while($row = $query_genre->fetch_object()) {
			$all_genres_name[] = $row->tema;
			$all_genres_image[] = $row->imagemTema;
		}
	}

	$all_genres_name_count = array_count_values($all_genres_name);
	$top3_genres_n = array_slice($all_genres_name_count, 0, 3);

	$all_genres_image_count = array_count_values($all_genres_image);
	$top3_genres_i = array_slice($all_genres_image_count, 0, 3);

	$top3_genres = [];

	$top3_genres_n = array_keys($top3_genres_n);
	$top3_genres_i = array_keys($top3_genres_i);
?>