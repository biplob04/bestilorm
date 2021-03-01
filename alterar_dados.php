<?php
	if(!isset($_SESSION['userEmail']))
		session_start(); 

	if(isset($_SESSION['userEmail'])) 
		require 'assets/get_cart_num.php';
	# Mandatory include init.php file (connects to the database)
	require_once 'assets/init.php';

	# Get all the themes stored in the dabase
	$query_c = $db->query("SELECT tema FROM temas ORDER BY tema");
	$genres = [];

	while($row = $query_c->fetch_object()) {
		$genres[] = $row;
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
	<link rel="stylesheet" href="css/alterar.css">

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
				<h1 id="test">Bestilorm</h1>
			</div>
			
			<div id="header-img"></div>
		</div>
		
		<div class="content">
			<div id="alterar-header">
				<p><span>Altera os seus Dados</span></p>
			</div>
			<div id="alterar-content">
				<div id="alterar-nome" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Nome: <span><?php echo $_SESSION['userFName'] . ' ' . $_SESSION['userLName']; ?></span></div>
						<div class="edit-btn noselect" id="edit-name" onclick="showHideContent('alterar-nome', 240)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="nome-content">
						<form action="assets/alterar_dados/alterar_nome.php" method="post" accept-charset="utf-8">
							<input type="text" name="" value="" placeholder="" style="display:none">
							<input type="text" name="fName" placeholder="Primeiro Nome" onkeypress="return onlyAlphaLetters(event)" required maxlength="45"><br><br>
							<input type="text" name="lName" placeholder="Último Nome" onkeypress="return onlyAlphaLetters(event)" required maxlength="45"><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-email" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Email: <span><?php echo $_SESSION['userEmail']; ?></span></div>
						<div class="edit-btn noselect"><i class="material-icons"  style="color:#9e9e9e">edit</i></div>
					</div>
				</div>

				<div id="alterar-password" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Password: <span>**********</span></div>
						<div class="edit-btn noselect" id="edit-pass" onclick="showHideContent('alterar-password', 310)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="pass-content">
						<form action="assets/alterar_dados/alterar_pass.php" method="post" accept-charset="utf-8">
							<input type="password" name="currPass" placeholder="Password Atual" required minlength="8" maxlength="45"><br><br>
							<input type="password" name="newPass" placeholder="Nova Password" required minlength="8" maxlength="45" id="newPass"><br><br>
							<input type="password" name="newPassR" placeholder="Repete a nova Password" required maxlength="45" id="newPassR" onfocusout="checkPass('newPass', 'newPassR', 'no-match-pass')"><br><br><br>
							<p id="no-match-pass">* Passwords não correspondem</p>
							<button type="submit" name="submit" onclick="return checkPass('newPass', 'newPassR', 'no-match-pass');">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-tel" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Telefone: <span><?php echo $_SESSION['userPhone']; ?></span></div>
						<div class="edit-btn noselect" id="edit-tel" onclick="showHideContent('alterar-tel', 180)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="tel-content">
						<form action="assets/alterar_dados/alterar_tel.php" method="post" accept-charset="utf-8">
							<input type="text" name="tel" pattern="^\d{9}$" onkeypress="return onlyNumber(event)" maxlength="9" placeholder="Novo Nº Telemóvel" required><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-BIn" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Nº BI: <span><?php echo $_SESSION['userBIn']; ?></span></div>
						<div class="edit-btn noselect" id="edit-nbi" onclick="showHideContent('alterar-BIn', 180)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="BIn-content">
						<form action="assets/alterar_dados/alterar_bi.php" method="post" accept-charset="utf-8">
							<input type="text" name="nBI" pattern="^\d{8}$" onkeypress="return onlyNumber(event)" maxlength="8" placeholder="Novo NºBI" required><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-morada" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Morada: <span><?php echo $_SESSION['userLocal']; ?></span></div>
						<div class="edit-btn noselect" id="edit-addr" onclick="showHideContent('alterar-morada', 180)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="morada-content">
						<form action="assets/alterar_dados/alterar_morada.php" method="post" accept-charset="utf-8">
							<input type="text" name="morada" placeholder="Nova Morada" required style="width:70%"><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-codPost" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Código Postal: <span><?php echo $_SESSION['userPostCod']; ?></span></div>
						<div class="edit-btn noselect" id="edit-codpos" onclick="showHideContent('alterar-codPost', 180)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="codPost-content">
						<form action="assets/alterar_dados/alterar_codP.php" method="post" accept-charset="utf-8">
							<input type="text" name="codPost" pattern="^\d{4}[-]\d{3}$" onfocusout="postalCode(this)" placeholder="Novo Código Postal" required><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>

				<div id="alterar-dataNasc" class="alterar-box">
					<div class="bar">
						<div class="bar-title">Data de Nascimento: <span><?php echo $_SESSION['userDoB']; ?></span></div>
						<div class="edit-btn noselect" id="edit-dob" onclick="showHideContent('alterar-dataNasc', 180)"><i class="material-icons">edit</i></div>
					</div>
					<div class="AC-divider"></div>
					<div id="dataNasc-content">
						<form action="assets/alterar_dados/alterar_dob.php" method="post" accept-charset="utf-8">
							<input type="date" name="DoB" placeholder="Data de Nascimento" required><br><br>
							<button type="submit" name="submit">Alterar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function showHideContent(cnt, hgt) {
			content = document.getElementById(cnt);
			content_height = content.style.height;

			if(content_height == (hgt + 'px')) {  /* If content's height is height passed by parameters */ 
				var id = setInterval(hide, 1);
				height = hgt;
			}
			else {
				var id = setInterval(show, 1);
				height = 30;
			}

			function show() {
				if(height == hgt) {
					clearInterval(id);
				}
				else {
					height = height + 5;
					content.style.height = height + 'px';
				}
			}	

			
			function hide() {
				if(height == 30) {
					clearInterval(id);
				}
				else {
					height = height - 5;
					content.style.height = height + 'px';
				}
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