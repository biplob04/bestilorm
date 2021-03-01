<?php
	session_start(); 
	if(isset($_SESSION['userEmail'])) 
		require 'assets/get_cart_num.php';
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
	require 'assets/get_latest_books.php';
	$id = 0; # Required for latest books
	require 'assets/get_popular_genres.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/popular_genres.css">
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
						<li><a href="index.php" class="current-pg">Home</a></li>
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
			
			<div id="header-img">
				<p>Bem-Vindo!</p>
			</div>

			<form action="livros.php" method="get" accept-charset="utf-8" id="search-frm">
				<input type="text" name="search" placeholder="Pesquisar" required>
				<select name="genre" id="search-slc">
					<option value="all-cat">Todas as temas</option>
					<?php foreach($genres as $genre): ?>
						<option value="<?php echo $genre->tema; ?>"><?php echo $genre->tema; ?></option>
					<?php endforeach; ?>
				</select>
				<button type="submit" id="search-btn"><i class="material-icons">search</i></button>
			</form>

<!-- 			<div id="HC-divider"></div> -->

		</div>
		
		<div class="content">
			<div id="latest-books">
				<p id="novidades">Novidades</p>
				<div id="before" onclick="hideBooks(true)" class="noselect">
						<i class="material-icons">navigate_before</i>
				</div>
				<div id="flex-books">
					<div id="lat-books1">
						<?php foreach ($lat_books1 as $book):?>
							<a href="livro.php?id=<?php echo $book->idLivro; ?>">
								<div class="lat-books" id="book-<?php echo $id; $id++; ?>">
									<div class="add-new">
										<img src="<?php echo $book->imagemLivro; ?>" height="250px">
										<div class="add-new-cart">
											<a href="assets/add_cart.php?idLivro=<?php echo $book->idLivro; ?>&index=true"><i class="material-icons">add_shopping_cart</i></a>
										</div>
									</div>
									<a href="livro.php?id=<?php echo $book->idLivro; ?>"><p class="book-titl"><?php echo $book->nomeLivro; ?></p></a>
									<p class="book-aut"><?php echo $book->nomeAutor; ?></p>
									<p class="book-price">€ <?php echo $book->precoLivro; ?></p>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
					<div id="lat-books2">
						<?php foreach ($lat_books2 as $book):?>
							<a href="#added">
								<div class="lat-books" id="book-<?php echo $id; $id++; ?>">
									<div class="add-new">
										<img src="<?php echo $book->imagemLivro; ?>" height="250px">
										<div class="add-new-cart">
											<a href="assets/add_cart.php?idLivro=<?php echo $book->idLivro; ?>&index=true"><i class="material-icons">add_shopping_cart</i></a>
										</div>
									</div>
									<p class="book-titl"><?php echo $book->nomeLivro; ?></p>
									<p class="book-aut"><?php echo $book->nomeAutor; ?></p>
									<p class="book-price">€ <?php echo $book->precoLivro; ?></p>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				<div id="next" onclick="hideBooks(false)" class="noselect">
					<i class="material-icons">navigate_next</i>
				</div>
			</div>

			<div id="popular-genres">
				<h3>Os genros mais populares:</h3>
				<div id="popular-content">
					<?php foreach ($top3_genres_n as $genre): ?>
						<a href="livros.php?genre=<?php echo $genre; ?>" class="pg"><?php echo $genre; ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="border-div"></div>

			<div id="services">
				<h3>Serviços de entrega</h3>
				<div id="services-content">
					<p>O Bestilorm apresenta duas formas de fazer entrega dos livros: <span>Digital</span> e <span>IRL</span>. Isso pode ser selecionado depois de comprar os livros.</p>
					<div class="services-book">
						<div id="ebooks">
							<h4>Digital</h4>
							<img src="media/ebook.png" height="120px">
							<p>Ao selecionar essa opção, todos os livros comprados serão enviados no formato .pdf para o mail do Cliente.</p>
						</div>
						<div id="books">
							<h4>IRL</h4>
							<img src="media/book.png" height="120px">
							<p>Ao selecionar essa opção, todos os livros comprados serão enviados no endereço que o Cliente colocou ao comprar os livros.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="xTra-space"></div>

		<?php include 'footer.html'; ?>
	</div>
	<script src="assets/js/latest_books.js"></script>
	<script>
		if (navigator.appVersion.indexOf("Chrome/") != -1) {
			document.getElementById('search-slc').style.padding = "11.5px 40px 11.5px 15px";
			document.getElementById('search-btn').style.height = "44px";
		}
	</script>
</body>
</html>