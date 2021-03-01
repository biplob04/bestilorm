<?php 
	session_start();
	require_once 'assets/init.php';

	if(isset($_SESSION['userEmail'])) {
		header("Location: alterar_dados.php");
		die();
	} 

	if(isset($_GET['cart'])) {
		if($_GET['cart'] == 'login') {
			$needLog = true;
		}
	}		

	$query = $db->query("SELECT tema FROM temas ORDER BY tema");
	$genres = [];

	while($row = $query->fetch_object()) {
		$genres[] = $row;
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Bestilorm</title>
	<link rel="stylesheet" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">   <!-- font-family: 'Titillium Web', sans-serif;-->
	<link rel="shortcut icon" href="media/favicon.ico"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
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
		</div>
		
		<div id="login-content">
			<div id="login-bg"></div>
			<div id="signin-frm">
				<form action="assets/signin.php" method="post" accept-charset="utf-8" id="login-frm">
					<h2>Entra no site</h2>

					<label for="userEmail" class="inp">
						<?php if (isset($_GET['email'])): ?>
							<input type="email" name="userEmail" value="<?php echo $_GET['email']; ?>" placeholder="&nbsp;" required>
						<?php else: ?>
							<input type="email" name="userEmail" placeholder="&nbsp;" required>
						<?php endif; ?>
						<span class="label">Email</span>
						<span class="border"></span>
					</label><br><br><br>

					<label for="userPass" class="inp">
						<input type="password" name="userPass" placeholder="&nbsp;" required minlenght="8" maxlength="20">
						<span class="label">Password</span>
						<span class="border"></span>
					</label><br><br><br><br>
					<button type="submit" value="submit" name="submit">Login</button>
				</form>

				<div class="or-divider">
					<h1><span>OU...</span></h1>
				</div>
				
				<form action="assets/register.php" method="post" accept-charset="utf-8" id="register-frm">
					<h2>Faça Register</h2>

					<label for="fNameR" class="inp small-inp">
						<input type="text" name="fNameR" placeholder="&nbsp;" onkeypress="return onlyAlphaLetters(event)" required maxlength="45">
						<span class="label">Primeiro Nome</span>
						<span class="border"></span>
					</label>

					<label for="lNameR" class="inp small-inp left-margin">
						<input type="text" name="lNameR" placeholder="&nbsp;" onkeypress="return onlyAlphaLetters(event)" required maxlength="45">
						<span class="label">Último Nome</span>
						<span class="border"></span>
					</label><br><br><br>

					<label for="userEmailR" class="inp">
						<input type="email" name="userEmailR" placeholder="&nbsp;" required>
						<span class="label">Email</span>
						<span class="border"></span>
					</label><br><br><br>

					<label for="userPassR" class="inp small-inp">
						<input type="password" id="userPassR" name="userPassR" placeholder="&nbsp;" required minlength="8" maxlength="20">
						<span class="label">Password</span>
						<span class="border"></span>
					</label>

					<label for="userPassAgR" class="inp small-inp left-margin">
						<input type="password" name="userPassAgR" id="userPassAgR" placeholder="&nbsp;" onfocusout="checkPass('userPassR', 'userPassAgR', 'no-match-password')" required minlength="8" maxlength="20">
						<span class="label">Confirme Password</span>
						<span class="border"></span>
						<p id="no-match-password">Passwords não correspondem</p>
					</label><br><br><br>

					<label for="userLocalR" class="inp">
						<input type="text" name="userLocalR" placeholder="&nbsp;" required>
						<span class="label">Morada</span>
						<span class="border"></span>
					</label><br><br><br>

					<label for="userPostCodR" class="inp smallest-inp">
						<input type="text" name="userPostCodR" pattern="^\d{4}[-]\d{3}$" onfocusout="postalCode(this)" placeholder="&nbsp;" required>
						<span class="label">Código Postal</span>
						<span class="border"></span>
						<p id="postCodError">Código Postal inválido.</p>
					</label>

					<label for="userPhoneR" class="inp smallest-inp left-margin2">
						<input type="text" name="userPhoneR" pattern="^\d{9}$" onkeypress="return onlyNumber(event)" maxlength="9" placeholder="&nbsp;" required>
						<span class="label">Nº telemóvel</span>
						<span class="border"></span>
					</label>

					<label for="userDoBR" class="inp smallest-inp left-margin2">
						<input type="date" name="userDoBR" placeholder="&nbsp;" required>
						<span class="label">Data de nascimento</span>
						<span class="border"></span>
					</label><br><br><br>

					<label for="userBInR" class="inp smallest-inp">
						<input type="text" name="userBInR" pattern="^\d{8}$" placeholder="&nbsp;" onkeypress="return onlyNumber(event)"maxlength="8" required>
						<span class="label">Número BI</span>
						<span class="border"></span>
					</label><br><br><br><br>

					<button type="submit" value="submit" name="submit" onclick="return checkPass('userPassR', 'userPassAgR', 'no-match-password')">Register</button>
				</form>
			</div>
		</div>
	</div>
<script src="assets/js/input_verifications.js"></script>
<script>
	// For some reason, this function was not being recognized if it was on an external file (only tried on input_verification.js)
	function onlyNumber(event) {
	    var code = String.fromCharCode(event.which);
	    var pattern = new RegExp(/[0-9\b]/);
	    return pattern.test(code);
	}

	needLog = <?php echo $needLog; ?>
	
	if(needLog == 1)
		alert('É preciso fazer login para aceder ao carrinho ou adicionar um livro ao carrinho.');
</script>
</body>
</html>