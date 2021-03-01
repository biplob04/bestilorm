<?php 
	session_start();
	if(!isset($_POST['submit'])) {
		header("Location: ../login.php?signin=error");
		die();
	}
	else {
		require_once 'init.php';

		$userEmail = $_POST['userEmail'];
		$userPass = $_POST['userPass'];

		if($result = $db->query("SELECT * FROM clientes WHERE emailCliente = '$userEmail';")) {
			# Check if the email exists or not, if not: ERROR! 
			$row_cnt = $result->num_rows;

			if($row_cnt == 0) {
				# If there's no email that the user typed, return back to sign in page.
				header("Location: ../login.php?signin=userEmail");
				die();
			}
		}

		$row = $result->fetch_assoc();

		$deHashPass = password_verify($userPass, $row['passwordCliente']);

		if(!$deHashPass) {
			header("Location: ../login.php?signin=userError&email=$userEmail");
			die();
		}
		else {
			$_SESSION['userFName'] = $row['pNomeCliente'];	# First Name
			$_SESSION['userLName'] = $row['uNomeCliente'];	# Last Name
			$_SESSION['userEmail'] = $row['emailCliente'];	# Email
			$_SESSION['userPass'] = $row['passwordCliente']; # Password
			$_SESSION['userLocal'] = $row['moradaCliente'];	# Address
			$_SESSION['userPostCod'] = $row['codpostalCliente'];	# Postal Code
			$_SESSION['userPhone'] = $row['telefoneCliente'];	# PHone Number
			$_SESSION['userDoB'] = $row['dataNasc'];	# Date of birth
			$_SESSION['userBIn'] = $row['numBi'];	# BI Number
			$_SESSION['userRegDt'] = $row['dataRegisto'];	# Date user signed in

			if($row['administrador'] == 1)
				$_SESSION['admin'] = $row['administrador'];

			header("Location: ../index.php?signin=success");
			die();
		}
	}


 ?>