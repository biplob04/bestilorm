<?php 
	if(isset($_POST['adicionar-autor'])) {
		$nameA = $_POST['nameAut'];
		$descA = $_POST['descAut'];
		$imageA = $_POST['imageAut'];

		require_once 'init.php';

		if($result = $db->query("SELECT nomeAutor FROM autores WHERE nomeAutor = '$nameA'")) {
			$row_cnt = $result->num_rows;

			if($row_cnt > 0) {
				header("Location: ../admin_books/add_book.php?author=exists");
				die();
			}

			$result->close();
		}

		$db->query("
				INSERT INTO autores (nomeAutor, descricaoAutor, imagemAutor)
				VALUES ('$nameA', '$descA', '$imageA');
			");

		header("Location: ../admin_books/add_book.php?author=added");
		die();
	}
 ?>