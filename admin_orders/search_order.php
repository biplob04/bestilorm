<?php 
	session_start(); 
	if(!isset($_SESSION['userEmail'])) {
		header("Location: index.php?loser");
	}
	require '../assets/init.php';
	$index = 0;

	if(isset($_GET['search-order']))
		include '../assets/admin_purposes/get_search_order.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel do Administrador</title>
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="stylesheet" href="../css/admin_book.css"> <!-- Has got almost the same style as admin_books soo, maybe change the name later? :D --> 
	<link rel="stylesheet" href="../css/admin_search.css">
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
				<li><a href="../admin.php"><i class="material-icons">dashboard</i><span>Geral</span></a></li>
				<li><a href="../admin-user.php"><i class="material-icons">supervised_user_circle</i><span>Utilizadores</span></a></li>
				<li><a href="../admin-book.php"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="../admin-order.php" class="current-opt"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="../index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>

		<div id="content">
			<p id="content-header">Encomendas por utilizador</p>
			<div class="search-content">
				<form action="search_order.php" method="get" accept-charset="utf-8" id="search-frm">
					<input type="text" name="search" placeholder="Pesquisar" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>" required>
					<select name="search_by" id="search-by">
						<option value="user_email" <?php if(isset($_GET['search_by'])) { if($_GET['search_by'] == 'user_email') { echo 'selected'; } } ?>>Email</option>
						<option value="user_name" <?php if(isset($_GET['search_by'])) { if($_GET['search_by'] == 'user_name') { echo 'selected'; } } ?>>Nome Completo</option>
						<option value="user_BI" <?php if(isset($_GET['search_by'])) { if($_GET['search_by'] == 'user_BI') { echo 'selected'; } } ?>>Nº BI</option>
					</select>
					<button type="submit" id="search-btn" name="search-order"><i class="material-icons">search</i></button>
				</form>
			</div> 
			<?php if(isset($_GET['search-order'])): ?>
				<?php if($order == true): ?>
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
								<?php foreach ($get_user_orders as $order): ?>
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
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php else: ?>
					<div id="registered-books">
						<table>
							<tbody>
								<tr>
									<td class="td-header">Nome</td>
									<td class="td-header">Email</td>
									<td class="td-header">-</td>
								</tr>
								<?php for ($i=0; $i < sizeof($name); $i++): ?>
									<tr>
										<td><?php echo $name[$i]; ?></td>
										<td><?php echo $email[$i]; ?></td>
										<td>
											<form action="search_order.php" method="get" accept-charset="utf-8">
												<button type="submit" name="search-order" style="border:0;background:none;"><span class="modal-btn noselect">Seleccionar</span></button>
												<input type="text" name="search" placeholder="Pesquisar" value="<?php echo $email[$i] ?>" style="display:none">
												<select name="search_by" id="search-by" style="display:none">
													<option value="user_email" selected></option>
												</select>
											</form>
										</td>
									</tr>
								<?php endfor; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>				
	</div>
	<script>
		function showModal(index, eClass) {
			eClass[index].style.display = 'block';
		}

		window.onclick = function(event) {
			var imgM = document.getElementsByClassName('img-modal');
			var descM = document.getElementsByClassName('desc-modal');

			for (var i = 0; i < imgM.length; i++) {
				if(event.target == imgM[i]) {
					imgM[i].style.display = 'none';
				} 
				if(event.target == descM[i]) {
					descM[i].style.display = 'none';
				} 
			}
		}
	</script>
</body>
</html>