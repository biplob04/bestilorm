<?php 
	session_start();

	if(isset($_SESSION['userEmail'])) {
		if(isset($_GET['idLivro'])) {
			$email = $_SESSION['userEmail'];
			$id = $_GET['idLivro'];
			$quant = isset($_GET['quant']) ? $_GET['quant'] : 1;

			require 'init.php';

			#Check if there's already an user email in encomendas with 0 as finalizado's value
			$query_enc = $db->query("
				SELECT idEncomenda 
				FROM encomendas 
				WHERE (emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL))")->num_rows; 

			if($query_enc == 0) {  # IF there aint. 
				$db->query("INSERT INTO encomendas (emailCliente) VALUES ('$email')");

				$query_enc = $db->query("
					SELECT idEncomenda 
					FROM encomendas 
					WHERE emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL)")->fetch_object();

				$idEnc = $query_enc->idEncomenda;

				$db->query("
					INSERT INTO livrosencomendas (idLivro, idEncomenda, quantidade)
					VALUES ($id, $idEnc, $quant)
					");

				header("Location: ../livro.php?id=$id&add_cart=success");
			}
			else { # IF there is.
				$query_enc = $db->query("
					SELECT idEncomenda 
					FROM encomendas 
					WHERE emailCliente = '$email' AND (finalizado = 0 OR finalizado IS NULL)")->fetch_object(); # Get idEncomenda to be used later

				$idEnc = $query_enc->idEncomenda; # Get idEncomenda to be used later

				$query_le = $db->query("
					SELECT idLivro 
					FROM livrosencomendas
					WHERE idLivro = $id AND idEncomenda = $idEnc")->num_rows; # Check if there's a row where idLivro = $id and idEncomenda = $idEnc at the same time.

				if($query_le == 0) { # IF there aint.
					$db->query("
						INSERT INTO livrosencomendas (idLivro, idEncomenda, quantidade)
						VALUES ($id, $idEnc, $quant)
						");
				}
				else {  # IF there is.
					$db->query("
						UPDATE livrosencomendas
						SET quantidade = $quant
						WHERE idLivro = $id AND idEncomenda = $idEnc
						");
				}

				if(isset($_GET['index']))
					header("Location: ../index.php?add_cart=success");
				else 
					header("Location: ../livro.php?id=$id&add_cart=success");
			}

		}
	}
	else {
		$id = $_GET['idLivro'];
		header("Location: ../login.php?cart=login");
		die();
	}
 ?>