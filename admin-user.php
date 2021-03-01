<?php 
	session_start(); 
	if(!isset($_SESSION['userEmail'])) {
		header("Location: index.php?loser");
	}
	require_once 'assets/admin_purposes/get_users.php';

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
	<link rel="stylesheet" href="css/admin_user.css">
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
				<li><a href="admin-user.php" class="current-opt"><i class="material-icons">supervised_user_circle</i><span>Utilizadores</span></a></li>
				<li><a href="admin-book.php"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="admin-order.php"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>

		<div id="content">
			<p id="content-header">Todos os utilizadores</p>
			<div id="registered-books">
				<table>
					<tbody>
						<tr>
							<td class="options-book"></td>
							<td class="td-header">Email</td>
							<td class="td-header">Primeiro Nome</td>
							<td class="td-header">Último Nome</td>
							<td class="td-header">Telefone</td>
							<td class="td-header">Morada</td>
							<td class="td-header">Código Postal</td>
							<td class="td-header">Data de Nascimento</td>
							<td class="td-header">Nº BI</td>
							<td class="td-header">Data de Registo</td>
							<td class="td-header">Admin</td>
						</tr>
						<?php foreach ($users as $user): ?>
							<tr>
								<td class="options-book">
								    <div id="delete-book">
								    	<a onclick="showModal(<?php echo $index; ?>, document.getElementsByClassName('delete-modal'))"><i class="material-icons">delete</i></a>
										<div class="delete-modal">
											<div class="delete-modal-cnt">
												<p>Apagar o utilizador "<?php echo $user->emailCliente; ?>"?</p>
												<a href="assets/admin_purposes/delete_user.php?email=<?php echo $user->emailCliente; ?>">Sim</a>
												<a onclick="document.getElementsByClassName('delete-modal')[<?php echo $index; ?>].style.display = 'none';">Não</a>
											</div>
										</div>
								    </div>
								</td>
								<td><?php echo $user->emailCliente; ?></td>
								<td><?php echo $user->pNomeCliente; ?></td>
								<td><?php echo $user->uNomeCliente; ?></td>
								<td><?php echo $user->telefoneCliente; ?></td>
								<td>
									<span class="modal-btn" onclick="showModal(<?php echo $index; ?>, document.getElementsByClassName('morada-modal'))">Morada</span>
									<div class="morada-modal">
										<div class="morada-modal-cnt">
											<?php echo $user->moradaCliente; ?>
										</div>
									</div>
								</td>
								<td><?php echo $user->codpostalCliente; ?></td>
								<td><?php echo $user->dataNasc; ?></td>
								<td><?php echo $user->numBi; ?></td>
								<td><?php echo $user->dataRegisto; ?></td>
								<td>
									<?php 
										if($user->administrador == 1)
											echo 'Sim'; 
									?>
										
								</td>
							</tr>
							<?php $index++; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="page-num" id="page-num">
					<?php
						for ($i=1; $i <= $user_pages_available; $i++) { 
							echo "<a href=admin-user.php?opage=$i>$i</a>";
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
			var deleteM = document.getElementsByClassName('delete-modal');

			for (var i = 0; i < morada.length; i++) {
				if(event.target == morada[i]) {
					morada[i].style.display = 'none';
				} 
				if(event.target == deleteM[i]) {
					deleteM[i].style.display = 'none';
				} 
			}
		}
	</script>
</body>
</html>