<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$phone = $_POST['tel'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET telefoneCliente = '$phone'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userPhone'] = $phone;

		header("Location: ../../alterar_dados.php?tele=changed");
	}

 ?>