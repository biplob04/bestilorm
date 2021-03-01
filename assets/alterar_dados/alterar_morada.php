<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$morada = $_POST['morada'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET moradaCliente = '$morada'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userLocal'] = $morada;

		header("Location: ../../alterar_dados.php?local=changed");
	}

 ?>