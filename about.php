<?php
	session_start(); 
	if(isset($_SESSION['userEmail'])) 
		require 'assets/get_cart_num.php';
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/about.css">
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
						
						<li><a href="about.php" class="current-pg">Sobre</a></li>

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

						<li>
							<a href="cart.php" class="cart-icon">
								<i class="material-icons">shopping_cart</i>
								<span>
									<?php 
										if(isset($_SESSION['userEmail'])) 
											echo $cartN;
										else 
											echo '0';
									 ?>
								</span>
							</a>
						</li>	
					</ul>
				</nav>
				<div id="logo"></div>
				<h1>Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>
		</div>
		
		<div class="content">
			<div class="box-about">
				<div id="first-box-about">
					Aqui tem as informações sobre o projeto.
				</div>
			</div>

			<div class="box-about">
				<div class="box-img"><img src="media/about/employees.jpg" height="350px"></div>
				<div class="box-txt" style="text-align:right">
					<h1 id="func">Funcionários</h1>
					<p>Os nossos funcionários são experientes e treinados para se envolver com os clientes, facilitando a escolha do livro/genre de livro que estão a procura.</p>
				</div>
			</div>
			<div class="box-about dark-about">
				<div class="box-txt">
					<h1 id="clie">Livro</h1>
					<p>Existem vários livros na loja, cada uma tem o seu genre principal, e livros com mesmo genres estão colocados no mesmo lugar, facilitando a sua procura. Os livros podem ser comprados no formato E-book ou no formato de papel, ambos desses formatos podem ser comprados no site ou na loja.</p>
				</div>
				<div class="box-img"><img src="media/about/client.jpeg" height="350px"></div>
			</div>
			<div class="box-about" id="shop-about">
				<div class="box-txt">
					<h1 id="clie">A Loja</h1>
					<p>A loja situa-se na Avenida da Liberdade 259B, tem 2 andares e tem lugares para as pessoas sentarem e lerem livros antes de os comprarem.</p>
				</div>
				<div class="box-img"><img src="media/about/shop.jpeg" height="450px"></div>
			</div>
			<div class="mapouter">
				<div class="gmap_canvas">
					<iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Av.%20da%20Liberdade%20259B&t=&z=18&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
			</div>
		</div>

		<?php include 'footer.html'; ?>
	</div>
</body>
</html>

