<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$bi = $_POST['nBI'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET numBi = '$bi'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userBIn'] = $bi;

		header("Location: ../../alterar_dados.php?bin=changed");
	}

 ?>