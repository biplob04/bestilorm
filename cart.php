<?php 
	session_start();

	if(!isset($_SESSION['userEmail'])) {
		header("Location: login.php?cart=login");
		die();
	}

	require 'assets/init.php'; # Mandatory include init.php file (connects to the database)
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
	require 'assets/get_cart_items.php'; # Gets all the items from cart.
	require 'assets/get_cart_num.php';
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
			<div id="cart-content">
				<?php if($query_EncLiv): ?>
					<?php if($query_EncLiv->num_rows > 0): ?>
						<table>
							<tbody>
								<tr>
									<td class="td-header">Livro</td>
									<td class="td-header">Quantidade</td>
									<td class="td-header">Preço</td>
									<td class="td-header"></td>
								</tr>
								<?php foreach ($books as $book): ?>
									<tr>
										<td rowspan="1" class="book-details">
			                            	<img src="<?php echo $book->imagemLivro; ?>" height="200px">
			                            	<div class="details">
			                            		<h2 class="book-name"><?php echo $book->nomeLivro; ?></h2><br>
			                            		<p>ID: <span><?php echo $book->idLivro; ?></span></p>
			                            	</div>
										</td>
										<td>
											<div id="quantity" class="noselect">
												<a href="livro.php?id=<?php echo $book->idLivro; ?>">
													<span id="minus" onclick="subQuant()">-</span>
													&nbsp;&nbsp;<input type="number" name="quant" value="<?php echo $book->quantidade; ?>" id="bookQuant" max="20" onkeypress="this.style.width = ((this.value.length + 1) * 8) + 'px';">&nbsp;&nbsp;
													<span id="plus" onclick="addQuant()">+</span>
												</a>
											</div>
										</td>
										<td>
											<div id="price" class="noselect">
												<span class="price-symb">€</span>
												<span id="preco">
													<?php 
														$price = round(($book->precoLivro * $book->quantidade), 2);
														echo $price;
													 ?>
												</span>
											</div>
										</td>
										<td class="remove-item">
											<div>
												<a href="assets/remove_cart_item.php?id=<?php echo $book->idLivro; ?>&idEnc=<?php echo $idEnc; ?>"><i class="material-icons">close</i></a>
											</div>	
										</td>
									</tr>
								<?php endforeach; ?>
								<tr>
									<td>
										<div id="removea">
											<a href="assets/remove_cart_items.php?idEnc=<?php echo $idEnc; ?>" style="text-decoration: none;width:210px">
												<div id="remove-all">
													Limpar Carrinho
												</div>
											</a>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					<?php endif; ?>
				<?php endif; ?>

				<?php if(!$query_EncLiv || $query_EncLiv->num_rows < 1): ?>
					<div class="noitems-car" style="padding:30px;font-size:30px;font-weight:100">
						Carrinho vazio.
					</div>
				<?php endif; ?>
			</div>
			<?php if($query_EncLiv): ?>
				<?php if($query_EncLiv->num_rows > 0): ?>
					<div id="cart-checkout">
						<h4>Preço total</h4>
						<h5>€ <?php echo $precoFinal; ?></h5>
						<div>
							<p onclick="document.getElementById('finalizar').style.display = 'initial';">Finalizar</p>
						</div>
					</div>

					<div id="finalizar">
						<div id="finalizar-content">
							<div id="closeF" class="noselect"><p onclick="document.getElementById('finalizar').style.display = 'none';">X</p></div>
							<p>Quer receber o(s) livros com dados pessoais do utilizador <span>(eg: na morada do utilizador, com nome/tel do utilizador, etc.)</span> ou com dados da outra pessoa?</p>
							<div id="finalizar-buttons">
								<p onclick="document.getElementById('utilizador-maneira').style.display = 'initial';document.getElementById('finalizar').style.display = 'none';">Utilizador</p>
								<p onclick="document.getElementById('outra').style.display = 'initial';document.getElementById('finalizar').style.display = 'none';">Outra</p>
							</div>
						</div>
					</div>

					<div id="utilizador-maneira">
						<div id="utilizador-content">
							<div id="closeU" class="noselect"><p onclick="document.getElementById('utilizador-maneira').style.display = 'none';">X</p></div>
							<p>Maneira de Entrega:</p>
							<div id="utilizador-buttons">
								<a href="assets/finalizar.php?id=<?php echo $query_idEnc->idEncomenda; ?>&p=uti&maneira=digital">Digital</a>
								<a href="assets/finalizar.php?id=<?php echo $query_idEnc->idEncomenda; ?>&p=uti&maneira=irl">Irl</a>
							</div>
						</div>
					</div>

					<div id="outra">
						<div id="outra-content">
							<div id="closeO" class="noselect"><p onclick="document.getElementById('outra').style.display = 'none';">X</p></div>
							<form action="assets/finalizar.php" method="post" accept-charset="utf-8">
								<p>Introduz os dados da pessoa a quem quiser enviar o(s) livros:</p>
								<input type="text" name="precoF" value="<?php echo $precoFinal; ?>" style="display:none;">
								<input type="text" name="name" placeholder="Nome Completo" size="35" required>
								<input type="text" name="address" placeholder="Morada" size="55" required>
								<input type="text" name="postCod" placeholder="Código Postal" pattern="^\d{4}[-]\d{3}$" onfocusout="postalCode(this)" required>
								<input type="tel" name="tel" placeholder="Nº de Telemóvel" pattern="^\d{9}$" onkeypress="return onlyNumber(event)"  maxlength="9" required>
								<select name="maneira">
									<option value="digital">Digital</option>
									<option value="irl">IRL</option>
								</select>

								<button type="submit" name="submitO">Submeter</button>
							</form>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php if($query_EncLiv): ?>
			<?php if(sizeof($out_of_stock_books) > 0): ?>
				<div class="order-books" id="OoS-books" style="display:block;">
					<div class="order-books-cnt">
						<div id="closeF" class="noselect"><p onclick="document.getElementById('OoS-books').style.display = 'none';">X</p></div>
						<p>De momento os livros listados são indisponível:</p>
						<ul>
							<?php foreach ($out_of_stock_books as $book): ?>
								<li><a href="livro.php?id=<?php echo $book->idLivro; ?>"><?php echo $book->nomeLivro; ?></a></li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>


		<?php if(!$query_EncLiv || $query_EncLiv->num_rows < 1): ?>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
		<?php else: ?>
			<div class="xTra-space"></div>
		<?php endif; ?>


		<?php include 'footer.html'; ?>
	</div>
	<script>
		window.onclick = function(event) {
			if(event.target == document.getElementById('finalizar')) {
				document.getElementById('finalizar').style.display = "none";
			}
			if(event.target == document.getElementById('outra')) {
				document.getElementById('outra').style.display = "none";
			}
			if(event.target == document.getElementById('utilizador-maneira')) {
				document.getElementById('utilizador-maneira').style.display = "none";
			}
		}

		function onlyNumber(event) {
		    var code = String.fromCharCode(event.which);
		    var pattern = new RegExp(/[0-9\b]/);
		    return pattern.test(code);
		}
	</script>
	<script src="assets/js/input_verifications.js"></script>
</body>
</html>