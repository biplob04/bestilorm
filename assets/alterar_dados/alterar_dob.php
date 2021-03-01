<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$dob = $_POST['DoB'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET dataNasc = '$dob'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userDoB'] = $dob;

		header("Location: ../../alterar_dados.php?dataNasc=changed");
	}

 ?>