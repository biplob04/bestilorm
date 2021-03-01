<?php 
	session_start();
	if(isset($_SESSION['userEmail'])) {
		if(isset($_GET['id']) && isset($_GET['idEnc'])) {
			$idB = $_GET['id'];
			$idEnc = $_GET['idEnc'];

			require 'init.php';

			$db->query("DELETE FROM livrosencomendas WHERE idLivro = $idB AND idEncomenda = $idEnc");
			header("Location: ../cart.php?deleted");
		}
	}


 ?>