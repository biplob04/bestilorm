<?php 
	require 'init.php';

	$email = $_SESSION['userEmail'];
	$query_idEnc = $db->query("
				SELECT idEncomenda 
				FROM encomendas 
				WHERE (emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL))")->fetch_object();
	
	if($query_idEnc) {
		$idEnc = $query_idEnc->idEncomenda; # This is the encomenda's id

		$cartN = $db->query("
					SELECT idLivro
					FROM livrosencomendas
					WHERE idEncomenda = $idEnc
			")->num_rows;
	}
	else {
		$cartN = 0;
	}
	
 ?>