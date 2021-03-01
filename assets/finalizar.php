<?php 
	date_default_timezone_set('Europe/Lisbon');

	if(isset($_GET['p'])) {
		if($_GET['p'] == 'uti') {
			session_start();

			$name = $_SESSION['userFName'] . ' ' . $_SESSION['userLName'];
			$address = $_SESSION['userLocal'];
			$codP = $_SESSION['userPostCod'];
			$tel = $_SESSION['userPhone'];

			require_once 'get_cart_items.php';

			updateEnc($precoFinal, $name, $address, $codP, $tel);
		}
	}

	if(isset($_POST['submitO'])) {
		session_start();

		$name = $_POST['name'];
		$address = $_POST['address'];
		$codP = $_POST['postCod'];
		$tel = $_POST['tel'];
		$tPrice = $_POST['precoF'];

		updateEnc($tPrice, $name, $address, $codP, $tel);
	}

	function updateEnc($tPrice, $name, $address, $codP, $tel) {
		$arrayM = array(rand(100, 999), rand(100, 999), rand(100, 999));
		$refM = implode("-",$arrayM);
		$eDate = date("Y-m-d");	# Current date
		$email = $_SESSION['userEmail'];
		$maneira = $_GET['maneira'];

		require 'init.php';

		$get_enc_id = $db->query("SELECT idEncomenda FROM encomendas WHERE emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL)")->fetch_object();

		$get_enc_id = $get_enc_id->idEncomenda;

		$query_books_id = $db->query("SELECT idLivro, quantidade
									  FROM livrosencomendas
									  WHERE idEncomenda = $get_enc_id

			");

		$get_books_id = [];

		while($row = $query_books_id->fetch_object()) 
			$get_books_id[] = $row;

		foreach ($get_books_id as $idLivro) {
			$id = $idLivro->idLivro;
			$quantity = $idLivro->quantidade;

			$get_stock = $db->query("SELECT stockLivro FROM livros WHERE idLivro = $id")->fetch_object()->stockLivro;

			$db->query("UPDATE livros
						SET stockLivro = ($get_stock - $quantity)
						WHERE idLivro = $id
				");
		}


		$db->query("
				UPDATE encomendas
				SET dataEncomenda = '$eDate', precoFinalLivros = $tPrice, finalizado = 1, refMultibanco = '$refM', nomeDestinario = '$name', moradaDestinario = '$address', codPostalDestinario = '$codP', telemovelDestinario = $tel, maneiraDeEntrega = '$maneira'
				WHERE emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL);
		");

		$_SESSION['order'] = 'success';

		header("Location: ../enc_finalizado.php?refMultibanco=$refM&price=$tPrice");
		die();
	}