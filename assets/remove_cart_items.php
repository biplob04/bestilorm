<?php 
	session_start();
	if(isset($_SESSION['userEmail'])) {
		if(isset($_GET['idEnc'])) {
			$idEnc = $_GET['idEnc'];

			require 'init.php';

			$db->query("DELETE FROM livrosencomendas WHERE idEncomenda = $idEnc");
			header("Location: ../cart.php?deleted");
		}
	}

 ?>