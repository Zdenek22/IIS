<?php

// funkce pro vytvoreni stranky pro zmeneni hodnot


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeChangePage()
//			mainPageButtons()
//			changeHeslo()/changeEmail()/changeTelefon()
//			userAccountInfo()
//			endChangePage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeChangePage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - změna údajů</title>
	</head>
	<body>
	<?php
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	?>
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Změna údajů</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}



function changeTelefon(){
	?>
	<div class="secondCol">
	<table style="width: 100%;border: 1px solid #ccc; border-collapse: collapse;">
			<tr>
				<td style="width: 20%;">Nový telefon</td>
				<form action="operations.php" method="post">
					<td style="text-align: left;">
						<input type="tel" name="telefon" pattern="[0-9]{3}[0-9]{3}[0-9]{3}">
						<input type="submit" name="changeTelefon" value="Změnit" style="color: white;background-color: #4CAF50;margin-right: 20%;">
					</td>
				</form>		
			</tr>
	</table>
	</div>		
	<?		
}

function changeEmail(){
	?>
	<div class="secondCol">
	<table style="width: 100%;border: 1px solid #ccc; border-collapse: collapse;">
			<tr>
				<td style="width: 20%;">Nový email</td>
				<form action="operations.php" method="post">
					<td style="text-align: left;">
						<input type="email" name="email" placeholder="xlogin@gmail.com">
						<input type="submit" name="changeEmail" value="Změnit" style="color: white;background-color: #4CAF50;margin-right: 20%;">
					</td>
				</form>		
			</tr>
	</table>
	</div>		
	<?		
}

function changeHeslo($error){
	?>
	<div class="secondCol">
	<table style="width: 100%;border: 1px solid #ccc; border-collapse: collapse;">
		<form action="operations.php" method="post">
			<tr>
				<td style="width: 20%;">Nové heslo</td>
					<td style="text-align: left;">
						<input type="password" name="heslo" required="required">
					</td>		
			</tr>
			<tr>
				<td style="width: 20%;">Heslo znovu</td>
					<td style="text-align: left;">
						<input type="password" name="heslo2" required="required">
					</td>	
			</tr>
			<tr>	
				<td style="width: 20%;"></td>
				<td style="text-align: center;">
				<input type="submit" name="changeHeslo" value="Změnit" style="color: white;background-color: #4CAF50;margin-right: 20%;">
				</td>
			</tr>
		</form>		
	</table>
	<?php
		if($error == 1){
			?>
			<div>Zadaná hesla se neshodují!</div>
			<?php
		}
	?>
	</div>		
	<?		
}



// ukonceni stranky
function endChangePage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
