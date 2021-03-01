<?php 
	session_start();

	if(!isset($_SESSION['userEmail'])) {
		header("Location: login.php");
		die();
	}

	$x = 0;

	require 'assets/get_cart_num.php';
	require 'assets/init.php'; # Mandatory include init.php file (connects to the database)
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
	require 'assets/all_orders.php'; # Gets all the items from cart.

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/cart.css">
	<link rel="stylesheet" href="css/compras_feitas.css">
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

						<li><a href="cart.php" class="cart-icon"><i class="material-icons">shopping_cart</i><span><?php echo $cartN; ?></span></a></li>
							
					</ul>
				</nav>
				<div id="logo"></div>
				<h1>Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>
		</div>
		
		<div class="content">
			<p>Todas as suas compras feitas</p>
			<div id="cart-content" style="width:95%">
				<?php if($query_orders): ?>
					<?php if($query_orders->num_rows > 0): ?>
						<table>
							<tbody>
								<tr>
									<td class="td-header">Nome</td>
									<td class="td-header">Morada</td>
									<td class="td-header">Código Postal</td>
									<td class="td-header">Telemóvel</td>
									<td class="td-header">Livros</td>
									<td class="td-header">Preço Final</td>
									<td class="td-header">Data</td>
								</tr>
								<?php foreach ($orders as $order): ?>
									<tr class="compras-content">
										<td><?php echo $order->nomeDestinario; ?></td>
										<td><?php echo $order->moradaDestinario; ?></td>
										<td><?php echo $order->codPostalDestinario; ?></td>
										<td><?php echo $order->telemovelDestinario; ?></td>
										<td>
											<div class="livros-compras noselect" onclick="showBooks(<?php echo $x; ?>);">
												Livros
											</div>
											<?php $x++;	 ?>
											<div class="order-books">
												<div class="order-books-cnt">
													<ol>
														<?php 
															$booksPrice = 0;

															for ($i=0; $i < sizeof($books[$order->idEncomenda]); $i++) {
																$booksPrice = $booksPrice + ($books[$order->idEncomenda][$i]->precoLivro * $books[$order->idEncomenda][$i]->quantidade);
															}

															$booksPrice = round($booksPrice, 2);
														 ?>

														<?php for ($i=0; $i < sizeof($books[$order->idEncomenda]); $i++): ?>
															<li><a href="livro.php?id=<?php echo $books[$order->idEncomenda][$i]->idLivro; ?>" target="_blank"><?php echo $books[$order->idEncomenda][$i]->nomeLivro; ?></a> <span>(<?php echo $books[$order->idEncomenda][$i]->quantidade; ?>)</span></li>
														<?php endfor; ?>

														<?php if($booksPrice != ($order->precoFinalLivros)): ?>
															<li>Não é possível mostrar alguns livros.</li>
														<?php endif; ?>
													</ol>
												</div>
											</div>
										</td>
										<td><div id="price">
												<span class="price-symb">€</span>
												<span id="preco">
													<?php echo $order->precoFinalLivros; ?>
												</span>
											</div></td>
										<td><?php echo $order->dataEncomenda; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				<?php endif; ?>
				<?php if(!$query_orders || $query_orders->num_rows < 1): ?>
					<div class="noitems-car" style="padding:30px;font-size:30px;font-weight:100">
						Ainda não efetuou nenhuma compra.
					</div>
				<?php endif; ?>
			</div>
			
		</div>

		<?php if(!$query_orders || $query_orders->num_rows < 1): ?>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
		<?php elseif ($query_orders->num_rows == 1): ?>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
		<?php else: ?>
			<div class="xTra-space"></div>
		<?php endif; ?>
		<?php include 'footer.html'; ?>
	</div>
	<script>
		function showBooks(index) {
			document.getElementsByClassName('order-books')[index].style.display = 'block';
		}

		window.onclick = function(event) {
			var modal = document.getElementsByClassName('order-books');
			for (var i = 0; i < modal.length; i++) {
				if(event.target == modal[i]) {
					modal[i].style.display = 'none';
				} 
			}
		}
	</script>
</body>
</html>