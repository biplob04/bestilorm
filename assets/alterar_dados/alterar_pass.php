<?php 
	session_start();
	if(isset($_POST['submit'])) {
		$currPass = $_POST['currPass'];
		$newPass = $_POST['newPass'];
		$email = $_SESSION['userEmail'];

		require '../init.php';

		$dePass = password_verify($currPass, $_SESSION['userPass']);

		if($dePass) {
			if($currPass != $newPass) {
				$passHash = password_hash($newPass, PASSWORD_DEFAULT); 

				$db->query("
					UPDATE clientes
					SET passwordCliente = '$passHash'
					WHERE emailCliente = '$email'
				");

				$db->close();

				$_SESSION['userPass'] = $passHas;

				header("Location: ../../alterar_dados.php?pass=changed");
				die();
			}
			else {
				header("Location: ../../alterar_dados.php?password=newCurrPass");
				die();
			}
			
		}
		else {
			header("Location: ../../alterar_dados.php?password=currPass");
			die();
		}

		
	}

 ?>