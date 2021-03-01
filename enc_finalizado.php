<?php 
	session_start();

	if(!isset($_SESSION['userEmail'])) {
		header("Location: login.php");
		die();
	}

	require 'assets/get_cart_num.php';
	require 'assets/init.php'; # Mandatory include init.php file (connects to the database)
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
	require 'assets/get_cart_items.php'; # Gets all the items from cart.
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/finalizar.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">   <!-- font-family: 'Titillium Web', sans-serif;-->
	<link rel="shortcut icon" href="media/favicon.ico"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  <!-- Material (Google) icons -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400" rel="stylesheet">    <!-- font-family: 'Nunito', sans-serif; -->
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="h-row">
				<nav>
					<ul>
						<li><a href="index.php">Home</a></li>
						<div class="dropdown">
							<li><a href="livros.php">Livros</a></li>
							<div class="drp-cnt" id="books-drp">
								<?php foreach ($genres as $genre):?>
									<a href="livros.php?genre=<?php echo $genre->tema; ?>"><?php echo $genre->tema;  ?></a>
								<?php  endforeach; ?>
							</div>
						</div>
						<li><a href="about.php">Sobre</a></li>
						
						<?php if(isset($_SESSION['userEmail'])): ?>
							<div class="dropdown">
								<li><a href="login.php" class="logged-in"><?php echo $_SESSION['userFName'] ?> <i class="material-icons">arrow_drop_down</i></a></li>
								<div class="drp-cnt">
									<a href="alterar_dados.php">Alterar Dados</a>
									<?php if(isset($_SESSION['admin'])): ?>
										<div class="admin-nav">
											<a href="admin.php">Admin</a>
										</div>
									<?php endif; ?>
									<a href="compras_feitas.php">Compras feitas</a>
									<a href="assets/logout.php">Logout</a>
								</div>
							</div>
						<?php else: ?>
							<li><a href="login.php">Login</a></li>
						<?php endif; ?>

						<li><a href="cart.php" class="cart-icon current-pg"><i class="material-icons">shopping_cart</i><span><?php echo $cartN; ?></span></a></li>
							
					</ul>
				</nav>
				<div id="logo"></div>
				<h1>Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>
		</div>
		
		<div class="content">
			<div id="referencia-content">
				<h2>Obrigado para usar o nosso serviço!</h2>
				<div id="factura-content">
					<?php if (isset($_SESSION['order'])): ?>
						<?php if($_SESSION['order'] == 'success'): ?>
							<p id="factura-header">Elementos da Factura</p>
							<div id="entidade" class="factura-element">
								<h3>Entidade</h3>	
								<p>63974</p>
							</div>
							<div id="referencia" class="factura-element">
								<h3>Referência</h3>		
								<p><?php echo $_GET['refMultibanco']; ?></p>				
							</div>
							<div id="montante" class="factura-element">
								<h3>Montante</h3>		
								<p><?php echo $_GET['price']; ?> €</p>			
							</div>	
							<div id="multibanco-logo">
								<img src="media/multibanco.png" height="131px" width="250px">
							</div>
						<?php endif; ?>
					<?php endif ?>		
				</div>
				<a href="index.php">Página principal</a>
			</div>
		</div>

		<div class="xTra-space"></div>
		<?php include 'footer.html'; ?>
	</div>
</body>
</html>