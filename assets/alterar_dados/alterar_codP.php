<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$codP = $_POST['codPost'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET codPostalCliente = '$codP'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userPostCod'] = $codP;

		header("Location: ../../alterar_dados.php?codPost=changed");
	}

 ?>