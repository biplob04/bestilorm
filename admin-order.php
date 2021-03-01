<?php 
	session_start(); 
	if(!isset($_SESSION['userEmail'])) {
		header("Location: index.php?loser");
	}
	require_once 'assets/admin_purposes/get_orders.php';

	$index = 0;
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel do Administrador</title>
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/admin_book.css"> <!-- Has got almost the same style as admin_books soo, maybe change the name later? :D --> 
	<link rel="stylesheet" href="css/admin_order.css">
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
				<li><a href="admin-book.php"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="admin-order.php" class="current-opt"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>

		<div id="content">
			<p id="content-header">Todos os utilizadores</p>
			<div id="registered-books">
				<table>
					<tbody>
						<tr>
							<td class="td-header">ID</td>
							<td class="td-header">Email</td>
							<td class="td-header">Nome</td>
							<td class="td-header">Morada</td>
							<td class="td-header">Código Postal</td>
							<td class="td-header">Telefone</td>
							<td class="td-header">Preço Final</td>
							<td class="td-header">Data de Encomenda</td>
							<td class="td-header">Referência Multibanco</td>
						</tr>
						<?php foreach ($orders as $order): ?>
							<tr>
								<td><?php echo $order->idEncomenda; ?></td>
								<td><?php echo $order->emailCliente; ?></td>
								<td><?php echo $order->nomeDestinario; ?></td>
								<td><?php echo $order->moradaDestinario; ?></td>
								<td><?php echo $order->codPostalDestinario; ?></td>
								<td><?php echo $order->telemovelDestinario; ?></td>
								<td><?php echo $order->precoFinalLivros; ?></td>
								<td><?php echo $order->dataEncomenda; ?></td>
								<td><?php echo $order->refMultibanco; ?></td>
							</tr>
							<?php $index++; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="page-num" id="page-num">
					<?php
						for ($i=1; $i <= $order_pages_available; $i++) { 
							echo "<a href=admin-order.php?oPage=$i>$i</a>";
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
			var morada = document.getElementsByClassName('morada-modal');

			for (var i = 0; i < morada.length; i++) {
				if(event.target == morada[i]) {
					morada[i].style.display = 'none';
				} 
			}
		}
	</script>
</body>
</html>