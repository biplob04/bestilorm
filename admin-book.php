<?php 
	session_start(); 
	if(!isset($_SESSION['userEmail'])) {
		header("Location: index.php?loser");
	}
	require_once 'assets/admin_purposes/get_books.php';

	$index = 0;
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel do Administrador</title>
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/admin_book.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">   <!-- font-family: 'Titillium Web', sans-serif;-->
	<link rel="shortcut icon" href="media/favicon.ico"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  <!-- Material (Google) icons -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400" rel="stylesheet">    <!-- font-family: 'Nunito', sans-serif; -->
</head>
<body>
	<div id="container">
		<div id="sidebar" class="noselect">
			<div id="user-details">
				<div id="acc-circle">
					<i class="material-icons">account_circle</i>
				</div>
				<div id="userName">
					<p id="fName"><?php echo $_SESSION['userFName']; ?></p>
					<p id="uEmail"><?php echo $_SESSION['userEmail']; ?></p>
				</div>
			</div>
			<ul>
				<li><a href="admin.php"><i class="material-icons">dashboard</i><span>Geral</span></a></li>
				<li><a href="admin-user.php"><i class="material-icons">supervised_user_circle</i><span>Utilizadores</span></a></li>
				<li><a href="admin-book.php" class="current-opt"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="admin-order.php"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>

		<div id="content">
			<p id="content-header">Todos os livros registados</p>
			<div id="registered-books">
				<table>
					<tbody>
						<tr>
							<td class="options-book"></td>
							<td class="td-header">ID</td>
							<td class="td-header">Nome</td>
							<td class="td-header">Tema</td>
							<td class="td-header">Autor</td>
							<td class="td-header">Editora</td>
							<td class="td-header">ISBN</td>
							<td class="td-header">Data de Publicação</td>
							<td class="td-header">Descrição</td>
							<td class="td-header">Preço</td>
							<td class="td-header">Stock</td>
							<td class="td-header">Imagem</td>
						</tr>
						<?php foreach ($books as $book): ?>
							<tr>
								<td class="options-book">
								    <div id="edit-book">
								    	<a href="admin_books/edit_book.php?id=<?php echo $book->idLivro; ?>"><i class="material-icons">edit</i></a>
								    </div><br>
								    <div id="delete-book">
								    	<a onclick="showModal(<?php echo $index; ?>, document.getElementsByClassName('delete-modal'))"><i class="material-icons">delete</i></a>
								    	<div class="delete-modal">
											<div class="delete-modal-cnt">
												<p>Apagar o Livro "<?php echo $book->nomeLivro; ?>"?</p>
												<a href="assets/admin_purposes/delete_book.php?id=<?php echo $book->idLivro; ?>">Sim</a>
												<a onclick="document.getElementsByClassName('delete-modal')[<?php echo $index; ?>].style.display = 'none';">Não</a>
											</div>
										</div>
									</div>
								</td>
								<td><?php echo $book->idLivro; ?></td>
								<td><?php echo $book->nomeLivro; ?></td>
								<td><?php echo $book->tema; ?></td>
								<td><?php echo $book->nomeAutor; ?></td>
								<td><?php echo $book->nomeEditora; ?></td>
								<td><?php echo $book->isbnLivro; ?></td>
								<td><?php echo $book->dataPublicLivro; ?></td>
								<td>
									<span class="modal-btn" onclick="showModal(<?php echo $index; ?>, document.getElementsByClassName('desc-modal'))">Descrição</span>
									<div class="desc-modal">
										<div class="desc-modal-cnt">
											<?php echo $book->descricaoLivro; ?>
										</div>
									</div>
								</td>
								<td><?php echo $book->precoLivro; ?></td>
								<td><?php echo $book->stockLivro; ?></td>
								<td>
									<span class="modal-btn" onclick="showModal(<?php echo $index; ?>, document.getElementsByClassName('img-modal'))">Imagem</span>
									<div class="img-modal">
										<div class="img-modal-cnt">
											<?php echo $book->imagemLivro; ?><br>
											<img src="<?php echo $book->imagemLivro; ?>" height="350px">
										</div>
									</div>
								</td>
							</tr>
							<?php $index++; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="page-num" id="page-num">
					<?php
						for ($i=1; $i <= $book_pages_available; $i++) { 
							echo "<a href=admin-book.php?bpage=$i>$i</a>";
						}
					 ?>
				</div>
			</div>
		</div>
	</div>
	<script>
		function showModal(index, eClass) {
			eClass[index].style.display = 'block';
		}

		window.onclick = function(event) {
			var imgM = document.getElementsByClassName('img-modal');
			var descM = document.getElementsByClassName('desc-modal');
			var deleteM = document.getElementsByClassName('delete-modal');

			for (var i = 0; i < imgM.length; i++) {
				if(event.target == imgM[i]) {
					imgM[i].style.display = 'none';
				} 
				if(event.target == descM[i]) {
					descM[i].style.display = 'none';
				}
				if(event.target == deleteM[i]) {
					deleteM[i].style.display = 'none';
				}  
			}
		}
	</script>
</body>
</html>