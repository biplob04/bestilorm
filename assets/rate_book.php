<?php 
	session_start();

	if(isset($_GET['submit'])) {
		$idLivro = $_GET['idLivro'];

		if(isset($_SESSION['userFName'])) {
			$userRate = $_GET['user-rate'];
			$comment = $_GET['rev-comment'];
			$userEmail = $_SESSION['userEmail'];
			$rateDate = date("Y-m-d");

			require 'init.php';

			if($result = $db->query("SELECT Clientes_emailCliente FROM classificacoes WHERE Clientes_emailCliente = '$userEmail' AND Livros_idLivro = $idLivro;")) {
				$row_cnt = $result->num_rows;

				if($row_cnt > 0) {
					$db->query("
							UPDATE classificacoes
							SET idClassificacao = $userRate, descricaoClassificacao = '$comment', Livros_idLivro = $idLivro, Clientes_emailCliente = '$userEmail', data_classificacao = '$rateDate'
							WHERE Clientes_emailCliente = '$userEmail' AND Livros_idLivro = $idLivro;
						");
					header("Location: ../livro.php?id=$idLivro");
					die();
				}

				$result->close(); 
			}

			$db->query("INSERT INTO classificacoes VALUES ($userRate, '$comment', $idLivro, '$userEmail', '$rateDate');");
			$db->close(); 

			header("Location: ../livro.php?id=$idLivro");
		}
		else {
			header("Location: ../livro.php?id=$idLivro&session=no");
			die();
		}
		
	}


 ?>