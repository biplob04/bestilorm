<?php 
	$id = $_POST['bookId'];

	if(isset($_POST['editarBook'])) {
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

		require_once 'init.php';

		$db->query("
				UPDATE livros
				SET nomeLivro = '$name', isbnLivro = '$isbn', idTema = $genre, idEditora = $publisher, idAutor = $author, dataPublicLivro = '$pubDate', descricaoLivro = '$description', stockLivro = $stock, precoLivro = $price, imagemLivro = '$imagePath'
				WHERE idLivro = $id;
			");


		header("Location: ../admin_books/edit_book.php?book=edited&id=$id");
		die();
	}
 ?>