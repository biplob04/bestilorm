<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$db->query("
				UPDATE clientes
				SET pNomeCliente = '$fName', uNomeCliente = '$lName'
				WHERE emailCliente = '$email'
			");

		$db->close();

		$_SESSION['userFName'] = $fName;
		$_SESSION['userLName'] = $lName;

		header("Location: ../../alterar_dados.php?name=changed");
	}

 ?>