<?php 
	if(isset($_POST['adicionar-editora'])) {
		$nameP = $_POST['namePubl'];
		$descP = $_POST['descPubl'];

		require_once 'init.php';

		if($result = $db->query("SELECT nomeEditora FROM editoras WHERE nomeEditora = '$nameP'")) {
			$row_cnt = $result->num_rows;

			if($row_cnt > 0) {
				header("Location: ../admin_books/add_book.php?publisher=exists");
				die();
			}

			$result->close();
		}

		$db->query("
				INSERT INTO editoras (nomeEditora, descricaoEditora)
				VALUES ('$nameP', '$descP');
			");

		header("Location: ../admin_books/add_book.php?publisher=added");
		die();
	}



 ?>