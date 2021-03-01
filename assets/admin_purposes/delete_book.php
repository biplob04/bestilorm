<?php 
	require_once '../init.php';
	$id = $_GET['id'];

	if($result = $db->query("SELECT idLivro FROM livros WHERE idLivro = $id")) {
		$row_cnt = $result->num_rows;

		if($row_cnt < 1) {
			header("Location: ../../admin.php?book=noId&id=$id");
			die();
		} 
	}

	$db->query("DELETE FROM livrosencomendas WHERE idLivro = $id");
	$db->query("DELETE FROM classificacoes WHERE Livros_idLivro = $id");
	$db->query("DELETE FROM livros WHERE idLivro = $id");
	header("Location: ../../admin-book.php?book=deleted");
	die();
 ?>