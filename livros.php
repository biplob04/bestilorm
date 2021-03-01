<?php
	session_start(); 
	if(isset($_SESSION['userEmail'])) 
		require 'assets/get_cart_num.php';

	require 'assets/init.php'; # Mandatory include init.php file (connects to the database)
	require 'assets/get_genres.php'; # Gets genres from DB to be implemented on the 'Livro's dropdown mennu.
	require 'assets/get_books.php'; # Gets books from DB to be displayed on page Livro.	
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/livros.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">   <!-- font-family: 'Titillium Web', sans-serif;-->
	<link rel="shortcut icon" href="media/favicon.ico"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  <!-- Material (Google) icons -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400" rel="stylesheet">    <!-- font-family: 'Nunito', sans-serif; -->
</head>
<body onload="randomColor()">
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
				<h1>Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>

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

			<div id="HC-divider"></div>
		</div>
		
		<div class="content">
			<?php foreach($books as $book): ?>
				<div class="prod-book">
					<a href="livro.php?id=<?php echo $book->idLivro; ?>">
						<div class="book-img"><img src="<?php echo $book->imagemLivro; ?>" height="250px"></div>
						<div class="book-price"><p><span class="price-symb">€</span><?php echo $book->precoLivro; ?></p></div>
						<div class="title-stars">
							<p><?php echo $book->nomeLivro; ?></p>
							<?php 
								$id = $book->idLivro;
								$query_rate = $db->query("SELECT AVG(idClassificacao) AS rating FROM classificacoes WHERE Livros_idLivro = $id");

								$avg_rating = $query_rate->fetch_object()->rating;
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
 
						</div>
						<div class="author-cat">
							<div class="category">
								<p class="cat-p"><?php echo $book->tema; ?></p>
							</div>
							<div class="author">
								<p>by <?php echo $book->nomeAutor; ?></p>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="page-num">
			<?php 
				for ($i=1; $i <= $pages_available; $i++) { 
					if($showBooks == 2) {
						if($userGenre == 'all-cat') 
							echo "<a href=livros.php?genre=all-cat&search=$userSearch&page=$i>$i</a>";
						else
							echo "<a href=livros.php?genre=$userGenre&search=$userSearch&page=$i>$i</a>";
					}
					elseif($showBooks == 1) {
						echo "<a href=livros.php?genre=$userGenre&page=$i>$i</a>";
					}
					elseif($showBooks == 0) {
						echo "<a href=livros.php?page=$i>$i</a>";
					}
				}
			 ?>
		</div>

		<?php if (sizeof($books) == 0): ?>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
			<div class="xTra-space"></div>
		<?php else: ?>
			<div class="xTra-space"></div>
		<?php endif; ?>
		<?php include 'footer.html'; ?>
	</div>
	<script>
		function randomColor() {
		    bookPrice = document.getElementsByClassName('book-price');
		    titleStars = document.getElementsByClassName('title-stars');
		    category = document.getElementsByClassName('cat-p');

		    for (var i = 0; i < bookPrice.length; i++) {
		    	random_number = Math.floor((Math.random() * 4) + 1);

		    	if(random_number == 1) {
		        	bookPrice[i].style.backgroundColor = "#8657a5";
		        	titleStars[i].style.borderLeftColor = "#8657a5";
		        	category[i].style.color = "#8657a5";
		    	}
		        else if(random_number == 2) {
		        	bookPrice[i].style.backgroundColor = "#49c5b6";
		        	titleStars[i].style.borderLeftColor = "#49c5b6";
		        	category[i].style.color = "#49c5b6";
		        }
		        else if(random_number == 3) {
		        	bookPrice[i].style.backgroundColor = "#FA824C";
		        	titleStars[i].style.borderLeftColor = "#FA824C";
		        	category[i].style.color = "#FA824C";
		        }
		        else if(random_number == 4) {
		        	bookPrice[i].style.backgroundColor = "#fe4157";
		        	titleStars[i].style.borderLeftColor = "#fe4157";
		        	category[i].style.color = "#fe4157";
		        }
		    }
		}
		

		if (navigator.appVersion.indexOf("Chrome/") != -1) {
			document.getElementById('search-slc').style.padding = "11.5px 40px 11.5px 15px";
			document.getElementById('search-btn').style.height = "49px";
		}
	</script>
</body>
</html>