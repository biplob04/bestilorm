<?php 
	if(isset($_POST['adicionar-tema'])) {
		$nameG = $_POST['nameGenre'];
		$descG = $_POST['descGenre'];

		require_once 'init.php';

		if($result = $db->query("SELECT tema FROM temas WHERE tema = '$nameG'")) {
			$row_cnt = $result->num_rows;

			if($row_cnt > 0) {
				header("Location: ../admin_books/add_book.php?genre=exists");
				die();
			}

			$result->close();
		}

		$db->query("
				INSERT INTO temas (tema, descricaoTema)
				VALUES ('$nameG', '$descG');
			");

		header("Location: ../admin_books/add_book.php?genre=added");
		die();
	}



 ?>