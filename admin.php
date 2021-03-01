<?php 
	session_start(); 
	if(!isset($_SESSION['admin'])) {
		header("Location: index.php?loser");
	}

	require_once 'assets/admin_purposes/get_user_rows.php';
	require_once 'assets/admin_purposes/get_book_rows.php';
	require_once 'assets/admin_purposes/get_order_rows.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel do Administrador</title>
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/delete_book.css">
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
				<li><a href="admin.php" class="current-opt"><i class="material-icons">dashboard</i><span>Geral</span></a></li>
				<li><a href="admin-user.php"><i class="material-icons">supervised_user_circle</i><span>Utilizadores</span></a></li>
				<li><a href="admin-book.php"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="admin-order.php"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>
		<div id="content">
			<div class="ubo-stats"> <!-- ubo = users/books/orders --> 
				<div id="userN" class="stats-panel">
					<p class="stats-icon" id="users-N">U</p>
					<p><?php echo $total_users; ?></p>
					<p>Utilizadores total</p>
				</div>
				<div id="userN" class="stats-panel">
					<p class="stats-icon" id="books-N">L</p>
					<p><?php echo $total_books; ?></p>
					<p>Livros total</p>
				</div>
				<div id="userN" class="stats-panel">
					<p class="stats-icon" id="orders-N">E</p>
					<p><?php echo $total_orders; ?></p>
					<p>Encomendas total feitas</p>
				</div>
			</div>
			<div class="ubo-stats">
				<div id="users-mod" class="stats-mod">
					<ul>
						<li><a href="admin-user.php">Ver todos os utilizadores</a></li>
						<li><a onclick="showModal(0, document.getElementsByClassName('modal-box'))">Apagar utilizador</a></li>
					</ul>
				</div>
				<div id="books-mod" class="stats-mod">
					<ul>
						<li><a href="admin-book.php">Ver todos os livros</a></li>
						<li><a href="admin_books/add_book.php">Inserir um novo livro</a></li>
						<li><a onclick="showModal(1, document.getElementsByClassName('modal-box'))">Apagar livro</a></li>
						<li><a onclick="showModal(2, document.getElementsByClassName('modal-box'))">Modificar dados do livro</a></li>
					</ul>			
				</div>
				<div id="orders-mod" class="stats-mod">
					<ul>
						<li><a href="admin-order.php">Ver todas as encomendas feitas</a></li>
						<li><a href="admin_orders/search_order.php">Ver encomendas feitas por utilizador</a></li>
					</ul>							
				</div>
			</div>

			<div class="space140px"></div>

			<div id="nota-mod">
				<div id="nota-users" class="warning-box">
					<p class="warning-ico"><i class="material-icons">error</i></p>
					<p>Para apagar um utilizador é preciso por o email desse utilizador no campo vazio.</p>
				</div>
				<div id="nota-books" class="warning-box">
					<p class="warning-ico"><i class="material-icons">error</i></p>
					<p>Para apagar/modificar os dados de um livro é preciso por o ID desse livro no campo vazio.</p>
				</div>
				<div id="nota-orders" class="warning-box">
					<p class="warning-ico"><i class="material-icons">error</i></p>
					<p>Para var as encomendas feitas por utilizador é preciso por o email desse utilizador no campo vazio.</p>
				</div>
			</div>
		</div>
	</div>
	<?php include 'admin_users/delete_user_modal.php'; ?>
	<?php include 'admin_books/delete_book_modal.php'; ?>
	<?php include 'admin_books/edit_book_modal.php'; ?>
	<script src="assets/js/modal.js"></script>
	<?php 
		if(isset($_GET['book'])) {
			if ($_GET['book'] == 'noId') {
				$message = 'Não existe um livro com id #' . $_GET['id'];

			    echo "<script type='text/javascript'> 
					    alert('$message');
					  </script>";

				die();
			}
		}
		else if (isset($_GET['user'])) {
			if($_GET['user'] == 'noE') {
				$message = 'Não existe utilizador com email ' . $_GET['email'];

				echo "<script type='text/javascript'> 
					    alert('$message');
					  </script>";

				die();
			}
		}

	 ?>
</body>
</html>