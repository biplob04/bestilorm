<?php 
	date_default_timezone_set('Europe/Lisbon');

	if(isset($_POST['adicionarBook'])) {
		$name = $_POST['bookName'];
		$isbn = $_POST['bookIsbn'];
		$genre = $_POST['temaSelect'];
		$author = $_POST['autSelect'];
		$publisher = $_POST['editSelect'];
		$pubDate = $_POST['pubDate'];
		$stock = $_POST['stock'];
		$price = $_POST['price'];
		$description = $_POST['descBook'];
		$imagePath = $_POST['image'];
		$currDate = date("Y-m-d");

		require_once 'init.php';

		$db->query("
				INSERT INTO livros (nomeLivro, isbnLivro, idTema, idEditora, idAutor, dataPublicLivro, descricaoLivro, stockLivro, precoLivro, imagemLivro, dataAdicionada)
				VALUES ('$name', '$isbn', $genre, $publisher, $author, '$pubDate', '$description', $stock, $price, '$imagePath', '$currDate');
			");


		header("Location: ../admin_books/add_book.php?book=added");
		die();
	}



 ?>