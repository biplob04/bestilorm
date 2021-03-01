<?php 
	if(!isset($_POST['submit'])) {
		header('Location: ../login.php?register=error');
		die();
	}
	else {
		# Do not despair! 
		require_once 'init.php';

		# Following variables are all associated with the client.
		$fName = $_POST['fNameR'];	# First Name
		$lName = $_POST['lNameR'];	# Last Name
		$userEmail = $_POST['userEmailR'];	# Email
		$userPass = $_POST['userPassR'];	# Password
		$userLocal = $_POST['userLocalR'];	# Address
		$userPostCod = $_POST['userPostCodR'];	# Postal Code
		$userPhone = $_POST['userPhoneR'];	# PHone Number
		$userDoB = $_POST['userDoBR'];	# Date of birth
		$userBIn = $_POST['userBInR'];	# BI Number
		$regDate = date("Y-m-d");	# Current date

		if($result = $db->query("SELECT emailCliente FROM clientes WHERE emailCliente = '$userEmail'")) {
			# this block of if checks if there's already a registered email in the database
			$row_cnt = $result->num_rows;

			if($row_cnt > 0) {
				# if, in fact, there is an identical email, then it stops the registration and goes back to login.php page
				header('Location: ../login.php?register=emailExists');
				die();
			}

			$result->close(); 
		}

		$userPassHash = password_hash($userPass, PASSWORD_DEFAULT); # Decrypts the user password

		$db->query("INSERT INTO clientes (emailCliente, pNomeCliente, uNomeCliente, passwordCliente, telefoneCliente, moradaCliente, codpostalCliente, dataNasc, numBi, dataRegisto) VALUES ('$userEmail', '$fName', '$lName', '$userPassHash', $userPhone, '$userLocal', '$userPostCod', '$userDoB', '$userBIn', '$regDate');"); # Insert user into the database

		header('Location: ../index.php?register=success');

		$db->close(); # Close db
		die();

	}


 ?>