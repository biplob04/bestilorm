<?php
	session_start(); 

	if(isset($_SESSION['userEmail'])) 
		require 'assets/get_cart_num.php';
	# Mandatory include init.php file (connects to the database)
	require_once 'assets/init.php';
	require 'assets/get_reviews.php';

	# Get all the themes stored in the dabase
	$query_c = $db->query("SELECT tema FROM temas ORDER BY tema");
	$genres = [];

	while($row = $query_c->fetch_object()) {
		$genres[] = $row;
	}

	if(isset($_GET['id'])) {
		$bookId = $_GET['id'];

		$book = $db->query("SELECT livros.idLivro, livros.nomeLivro, livros.precoLivro, livros.imagemLivro, autores.idAutor, autores.nomeAutor, temas.tema, livros.descricaoLivro, livros.stockLivro
							   FROM livros
							   INNER JOIN temas
							   ON livros.idTema=temas.idTema
							   INNER JOIN autores
							   ON livros.idAutor=autores.idAutor
							   WHERE idLivro = $bookId")->fetch_object();

		$author = $db->query("SELECT descricaoAutor, imagemAutor FROM autores WHERE idAutor = $book->idAutor")->fetch_object();
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/livro.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">   <!-- font-family: 'Titillium Web', sans-serif;-->
	<link rel="shortcut icon" href="media/favicon.ico"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  <!-- Material (Google) icons -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">    <!-- font-family: 'Nunito', sans-serif; -->
</head>	
<body>
	<div class="container">
		<div class="header">
			<div class="h-row">
				<nav>
					<ul>
						<li><a href="index.php">Home</a></li>
						<div class="dropdown">
							<li><a href="livros.php" class="current-pg">Livros</a></li>
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
				<h1 id="test">Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>
		</div>
		
		<div class="content">
			<div class="book">
				<div class="book-img">
					<img src="<?php echo $book->imagemLivro; ?>" height="400px">
				</div>
				<div class="title-stars">
					<?php 
						$id = $book->idLivro;
						$query_rate = $db->query("SELECT AVG(idClassificacao) AS rating FROM classificacoes WHERE Livros_idLivro = $id")->fetch_object();

						$avg_rating = $query_rate->rating;
					?>

					<?php if($avg_rating == 0 || $avg_rating == NULL): ?>
						<img src="media/stars/0.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 1 && $avg_rating < 1.5): ?>
						<img src="media/stars/1.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 1.5 && $avg_rating < 2): ?>
						<img src="media/stars/15.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 2 && $avg_rating < 2.5): ?>
						<img src="media/stars/2.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 2.5 && $avg_rating < 3): ?>
						<img src="media/stars/25.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 3 && $avg_rating < 3.5): ?>
						<img src="media/stars/3.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 3.5 && $avg_rating < 4): ?>
						<img src="media/stars/35.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 4 && $avg_rating < 4.5): ?>
						<img src="media/stars/4.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating >= 4.5 && $avg_rating < 5): ?>
						<img src="media/stars/45.png" height="15px">
					<?php endif; ?>

					<?php if($avg_rating == 5): ?>
						<img src="media/stars/5.png" height="15px">
					<?php endif; ?>
					<p id="rate-count">(<?php echo $db->query("SELECT idClassificacao FROM classificacoes WHERE Livros_idLivro = $id;")->num_rows; ?>)</p>  <!-- number of users who've rated the product -->

					<p><?php echo $book->nomeLivro; ?></p>
				</div>
				<div class="tema-autor">
					<p>Tema: <span><a href="livros.php?genre=<?php echo $book->tema; ?>"><?php echo $book->tema; ?></a></span></p>
					<p>Autor: <span><a href="livros.php?autor=<?php echo $book->nomeAutor; ?>"><?php echo $book->nomeAutor; ?></a></span></p>
				</div>
				<div id="desc-book">
					<p><?php echo $book->descricaoLivro; ?></p>
				</div>

				<div class="book-product">
					<div id="BP-divider"></div>
					<div id="stock"><i class="material-icons">check_circle</i> Em stock</div>

					<form action="assets/add_cart.php" method="get" accept-charset="utf-8">
						<input type="text" name="idLivro" value="<?php echo $book->idLivro; ?>" style="display:none;">

						<div id="price" class="noselect"><span class="price-symb">€</span><span id="preco"><?php echo $book->precoLivro ?></span></div>

						<div id="quantity" class="noselect">
							<span id="minus" onclick="subQuant()">-</span>
							&nbsp;&nbsp;<input type="number" name="quant" value="1" id="bookQuant" max="<?php echo $book->stockLivro; ?>" onkeypress="this.style.width = ((this.value.length + 1) * 8) + 'px';">&nbsp;&nbsp;
							<span id="plus" onclick="addQuant()">+</span>
						</div>

						<div id="product-id">Disponível: <span><?php echo $book->stockLivro; ?></span></div>
						
						<div id="add-cart">
							<?php if($book->stockLivro == 0): ?>
								<button type="submit" name="submit" value="submit" disabled>Adicionar ao carrinho</button>
							<?php else: ?>
								<button type="submit" name="submit" value="submit">Adicionar ao carrinho</button>
							<?php endif; ?>
						</div>
					</form>
					
				</div>
			</div>

			<div class="author">
				<div class="bar">
					<div class="bar-title">Autor</div>
					<div class="close-btn noselect" onclick="showHideAuthor()">-</div>
				</div>
				<div class="AR-divider"></div>
				<div class="author-content">
					<div class="author-img" style="background-image: url('<?php echo $author->imagemAutor; ?>')"></div>
					<div class="author-desc"><?php echo $author->descricaoAutor; ?></div>
				</div>
			</div>

			<div id="reviews">
				<div class="bar">
					<div class="bar-title">Comentários</div>
					<div class="close-btn noselect">-</div>
				</div>
				<div class="AR-divider"></div>
				<div id="reivews-content">
					<form action="assets/rate_book.php?" method="get" accept-charset="utf-8">
						<div id="rate">
							<input type="text" name="idLivro" value="<?php echo $book->idLivro; ?>" style="display:none;">
							<h1>Deixa o seu comentário</h1>
							<h2>Classificação:</h2>
							<div class="rating">
								<input type="radio" name="user-rate" id="rate-5" class="rating-input" value="5" required>
								<label for="rate-5" class="rating-star"></label>

								<input type="radio" name="user-rate" id="rate-4" class="rating-input" value="4" required>
								<label for="rate-4" class="rating-star"></label>

								<input type="radio" name="user-rate" id="rate-3" class="rating-input" value="3" required>
								<label for="rate-3" class="rating-star"></label>

								<input type="radio" name="user-rate" id="rate-2" class="rating-input" value="2" required>
								<label for="rate-2" class="rating-star"></label>

								<input type="radio" name="user-rate" id="rate-1" class="rating-input" value="1" required>
								<label for="rate-1" class="rating-star"></label>
							</div>					
						</div>
						<div id="review-comment">
							<label for="rev-comment">Comentário:</label>
							<textarea name="rev-comment" maxlength="250" id="rev-comment" placeholder="Lipsum.."></textarea>
						</div>
						<button type="submit" name="submit" id="rev-button">Adicionar</button>
					</form>
				</div>
				<?php foreach($reviews as $review): ?>
					<div class="user-reviews">
						<div class="user-details">
							<h3><?php echo $review->pNomeCliente . ' ' . $review->uNomeCliente; ?></h3>
							<h4><?php echo $review->data_classificacao; ?></h4>

							<?php if($review->idClassificacao == 1): # If user rates 1 on article?> 
								<img src="media/stars/1.png" height="15px"> 
							<?php endif; ?>
							<?php if($review->idClassificacao == 2): # If user rates 2 on article?>
								<img src="media/stars/2.png" height="15px">
							<?php endif; ?>
							<?php if($review->idClassificacao == 3): # If user rates 3 on article?>
								<img src="media/stars/3.png" height="15px">
							<?php endif; ?>
							<?php if($review->idClassificacao == 4): # If user rates 4 on article?>
								<img src="media/stars/4.png" height="15px">
							<?php endif; ?>
							<?php if($review->idClassificacao == 5): # If user rates 5 on article?>
								<img src="media/stars/5.png" height="15px">
							<?php endif; ?>
							
							<p><?php echo $review->descricaoClassificacao; ?></p>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="page-num" id="page-num">
					<?php
						for ($i=1; $i <= $cPagesAvailable; $i++) { 
							echo "<a href=livro.php?id=$bookId&cpage=$i>$i</a>";
						}
					 ?>
				</div>
			</div>
		</div>
		<div class="xTra-space"></div>
		<?php include 'footer.html'; ?>
	</div>
	<script>
		bookQuant = document.getElementById('bookQuant');
		bookPrice = document.getElementById('preco');
		ogPrice = <?php echo $book->precoLivro; ?>;
		x = 0;
		var height = 170;

		function showHideAuthor() {
			author = document.getElementsByClassName('author');
			closeBtn = document.getElementsByClassName('close-btn');
			barTitle = document.getElementsByClassName('bar-title');

			if(height == 170) {
				var id = setInterval(hide, 1);
			}
			else if(height == 0) {
				var id = setInterval(show, 1);
			}
			

			function hide() {
				if(height == 0) {
					clearInterval(id);
					height = 0;
					closeBtn[0].textContent = "+";
					barTitle[0].style.color = "#9e9e9e";
					closeBtn[0].style.color = "#9e9e9e";
				}
				else {
					height = height - 5;
					author[0].style.height = height + 'px';
				}
			}

			function show() {
				if(height == 170) {
					clearInterval(id);
					height = 170;
					closeBtn[0].textContent = "-";
					barTitle[0].style.color = "#49c5b6";
					closeBtn[0].style.color = "#49c5b6";
				}
				else {
					height = height + 5;
					author[0].style.height = height + 'px';
				}
			}
		}

		function addQuant() {
			if(bookQuant.value < <?php echo $book->stockLivro; ?>) { 
				bookQuant.value++;
				bookQuant.style.width = ((bookQuant.value.length + 1) * 8) + 'px';
				x = parseFloat(bookPrice.innerText) + ogPrice;
				bookPrice.innerText = Math.round(x * 100) / 100;
			}
		}

		function subQuant() {
			if(bookQuant.value > 1) {
				bookQuant.value--;
				bookQuant.style.width = ((bookQuant.value.length + 1) * 8) + 'px';
				x = parseFloat(bookPrice.innerText) - ogPrice;
				bookPrice.innerText = Math.round(x * 100) / 100;
			}
		}
	</script>
</body>
</html>