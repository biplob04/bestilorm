<?php 
	session_start(); 
	if(!isset($_SESSION['admin'])) {
		header("Location: index.php?loser");
		die();
	}

	require '../assets/get_genres.php';
	require '../assets/get_authors.php';
	require '../assets/get_publishers.php'
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel do Administrador</title>
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="stylesheet" href="../css/admin_books.css">
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
				<li><a href="../admin-book.php" class="current-opt"><i class="material-icons">library_books</i><span>Livros</span></a></li>
				<li><a href="../admin-order.php"><i class="material-icons">shopping_cart</i><span>Encomendas</span></a></li>
				<li><a href="../index.php"><i class="material-icons">settings_backup_restore</i><span>Voltar</span></a></li>
			</ul>
		</div>
		<div id="content">
			<div id="nota-books" class="warning-box">
				<p class="warning-ico"><i class="material-icons">error</i></p>
				<p>Se quiser adicionar um novo autor/editor/tema, é só preciso clicar no Adicionar Novo no campo respetivo e preencher os campos vazios.</p>
			</div>

			<div id="insert-book">
				<div id="insertB-title">
					<i class="material-icons noselect">add_box</i>
					<p>Adicionar um novo livro</p>
				</div>
				<div id="insertB-form">
					<form action="../assets/add_book.php" method="post" accept-charset="utf-8">
						<div class="inputB">
							<label for="bookInput" id="bookInput">Nome</label>
							<input type="text" name="bookName" size="25" onfocus="inputInteraction('#292f36', 'bookInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'bookInput'); } else { inputInteraction('#49C5B6', 'bookInput'); }" required>
						</div>
						<div class="inputB" style="width:20%">
							<label for="isbnInput" id="isbnInput">ISBN</label>
							<input type="text" name="bookIsbn" maxlength="12" size="20" onfocus="inputInteraction('#292f36', 'isbnInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'isbnInput'); } else { inputInteraction('#49C5B6', 'isbnInput'); }" required>
						</div>
						<div class="inputB" style="width:27%">
							<label for="temaSelect" id="temaSelect" style="color:#49C5B6">Tema</label>
							<select name="temaSelect" style="width:130px">
								<?php foreach($genres as $genre): ?>
									<option value="<?php echo $genre->idTema; ?>"><?php echo $genre->tema; ?></option>
								<?php endforeach; ?>
							</select>
							<p class="add-x noselect" onclick="document.getElementsByClassName('add-x-modal')[0].style.display = 'block';">Adicionar Nova</p>
						</div>
						<div class="inputB" style="width:31%">
							<label for="autSelect" id="autSelect" style="color:#49C5B6">Autor</label>
							<select name="autSelect" style="width:180px">
								<?php foreach($authors as $author): ?>
									<option value="<?php echo $author->idAutor; ?>"><?php echo $author->nomeAutor; ?></option>
								<?php endforeach; ?>
							</select>
							<p class="add-x noselect" onclick="document.getElementsByClassName('add-x-modal')[1].style.display = 'block';">Adicionar Novo</p>
						</div>
						<div class="inputB" style="width:33%">
							<label for="editSelect" id="editSelect" style="color:#49C5B6">Editora</label>
							<select name="editSelect" style="width:200px">
								<?php foreach($publishers as $publisher): ?>
									<option value="<?php echo $publisher->idEditora; ?>"><?php echo $publisher->nomeEditora; ?></option>
								<?php endforeach; ?>
							</select>
							<p class="add-x noselect" onclick="document.getElementsByClassName('add-x-modal')[2].style.display = 'block';">Adicionar Nova</p>
						</div>
						<div class="inputB" style="width:20%">
							<label for="dateInput" id="dateInput">Data de Publicação</label>
							<input type="text" name="pubDate" maxlength="4" size="10" onfocus="inputInteraction('#292f36', 'dateInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'dateInput'); } else { inputInteraction('#49C5B6', 'dateInput'); }" required>
						</div>
						<div class="inputB" style="width:20%">
							<label for="stockInput" id="stockInput">Stock presente</label>
							<input type="text" name="stock" maxlength="5" size="10" onfocus="inputInteraction('#292f36', 'stockInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'stockInput'); } else { inputInteraction('#49C5B6', 'stockInput'); }" required>
						</div>
						<div class="inputB" style="width:18%">
							<label for="priceInput" id="priceInput">Preço</label>
							<input type="number" name="price" size="10" min="0.00" max="100000.00" step="0.01" onfocus="inputInteraction('#292f36', 'priceInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'priceInput'); } else { inputInteraction('#49C5B6', 'priceInput'); }" required>
						</div>
						<div class="inputB" style="width:40%;">
							<label for="descInput" id="descInput">Descrição</label>
							<textarea name="descBook" maxlength="500" onfocus="inputInteraction('#292f36', 'descInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'descInput'); } else { inputInteraction('#49C5B6', 'descInput'); }"></textarea>
						</div>
						<div class="inputB" style="width:28%;height:85px">
							<label for="imageInput" id="imageInput">Caminho para a imagem</label>
							<input type="text" name="image" maxlength="50" size="30" onfocus="inputInteraction('#292f36', 'imageInput');" onfocusout="if(this.value == '') { inputInteraction('red', 'imageInput'); } else { inputInteraction('#49C5B6', 'imageInput'); }" required>
						</div>
						<button type="submit" name="adicionarBook" value="s">Adicionar</button>
					</form>
				</div>
			</div>
		</div>



		<div class="add-x-modal" id="tema-modal">
			<div class="add-x-content">
				<div class="add-x-header">
					<p>Adicionar uma nova tema</p>
					<i class="material-icons" onclick="document.getElementsByClassName('add-x-modal')[0].style.display = 'none';">close</i>
				</div>
				<form action="../assets/add_genre.php" method="post" accept-charset="utf-8">
					<input type="text" name="nameGenre" placeholder="Tema" required>
					<textarea name="descGenre" placeholder="Descrição da Tema" maxlength="250" required></textarea>
					<button type="submit" name="adicionar-tema">Adicionar</button>
				</form>
			</div>
		</div>

		<div class="add-x-modal" id="autor-modal">
			<div class="add-x-content">
				<div class="add-x-header">
					<p>Adicionar um novo autor</p>
					<i class="material-icons" onclick="document.getElementsByClassName('add-x-modal')[1].style.display = 'none';">close</i>
				</div>
				<form action="../assets/add_author.php" method="post" accept-charset="utf-8">
					<input type="text" name="nameAut" placeholder="Nome do Autor" required>
					<textarea name="descAut" placeholder="Descrição do Autor" maxlength="250" required></textarea>
					<input type="text" name="imageAut" placeholder="Caminho para a imagem do autor" size="30" required>
					<button type="submit" name="adicionar-autor">Adicionar</button>
				</form>
			</div>
		</div>

		<div class="add-x-modal" id="editora-modal">
			<div class="add-x-content">
				<div class="add-x-header">
					<p>Adicionar uma nova editora</p>
					<i class="material-icons" onclick="document.getElementsByClassName('add-x-modal')[2].style.display = 'none';">close</i>
				</div>
				<form action="../assets/add_publisher.php" method="post" accept-charset="utf-8">
					<input type="text" name="namePubl" placeholder="Nome da Editora" required>
					<textarea name="descPubl" placeholder="Descrição da Editora" maxlength="250" required></textarea>
					<button type="submit" name="adicionar-editora">Adicionar</button>
				</form>
			</div>
		</div>


	</div>
	<script>
		function inputInteraction(color, label) {
 			document.getElementById(label).style.color = color;
		}

		window.onclick = function() {
			var addX = document.getElementsByClassName('add-x-modal');
			
			if(event.target == addX[0]) 
				addX[0].style.display = 'none';

			if(event.target == addX[1]) 
				addX[1].style.display = 'none';

			if(event.target == addX[2]) 
				addX[2].style.display = 'none';
		}
	</script>
</body>
</html>