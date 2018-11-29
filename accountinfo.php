<?php

// funkce pro vytvoreni account page


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeAccountPage()
//			mainPageButtons()
//			startAccountTable()
//			fillAccountTable()  -> vyplni tabulku informacemi o uzivateli
//			endAccountTable()
//			userAccountInfo()
//			endAccountPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeAccountPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - účet</title>
	</head>
	<body>
		<h1>Lékárna</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// Vytvori tabulku s uzivatelem
function startAccountTable(){
	?>
	<div class="secondCol" style="border: 1px solid #ccc;">
		<table class="accountTable">
	<?php			
}

// naplni tabulku informacemi o uzivateli
function fillAccountTable(){
/*
	$server = new Database_access();
	$reserv = $server->getInformation($id);*/


	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	$status = -1;
	if($user['postaveni'] == 0){
		$status = "zaměstnanec";
	}
	else{
		$status = "správce";
	}

	?>	
	<tr>
		<td class="des">Login:</td>
		<td class="val"><? echo $_SESSION['user']; ?></td>
	</tr>
	<tr>
		<td class="des">Jméno:</td>
		<td class="val"><? echo $user['jmeno'];?></td>
	</tr>
	<tr>
		<td class="des">Příjmení:</td>
		<td class="val"><?echo $user['prijmeni']; ?></td>
	</tr>
	<tr>
		<td class="des">Email:</td>
		<?php
		if(!(isset($user['email']))){
			?>
			<td class="val">N/A</td>
			<?php
		}
		else{
			?>
			<td class="val"><? echo $user['email']; ?></td>
			<?php
		}
		?>
		<td>
			<form>
				<input class="changeButton" type="button" name="change" value="Změnit">
			</form>
		</td>
	</tr>
	<tr>
		<td class="des">Telefon:</td>
		<?php
		if(!(isset($user['telefon']))){
			?>
			<td class="val">N/A</td>
			<?php
		}
		else{
			?>
			<td class="val"><? echo $user['telefon']; ?></td>
			<?php
		}
		?>
		<td>
			<form>
				<input class="changeButton" type="button" name="change" value="Změnit">
			</form>
		</td>
	</tr>
	<tr>
		<td class="des">Status:</td>
		<td class="val"><? echo $status; ?></td>
	</tr>

<?php
}

// konec tabulky uctu
function endAccountTable(){
	?>
		</table>	<!-- konec tabulky -->
	</div>			<!-- konec secondCol -->
	<?php	
}


// prida na stranku informace o uzivateli
function userAccountInfo(){
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	$status = -1;
	if($user['postaveni'] == 0){
		$status = "zaměstnanec";
	}
	else{
		$status = "správce";
	}

	$mail;
	$phone;

	if(!(isset($user['telefon']))){
		$phone = "N/A";
	}
	else{
		$phone = $user['telefon'];
	}

	if(!(isset($user['email']))){
		$mail = "N/A";
	}
	else{
		$mail = $user['email'];
	}

	?>	
	
	<div class="thirdCol">
		<div class="infoWithoutFind">
			Uživatel: <? echo $user['jmeno'];echo " "; echo $user['prijmeni']; ?><br>
			Login: <? echo $_SESSION['user']; ?><br>
			Email: <? echo $mail; ?><br>
			Telefon: <? echo $phone; ?><br>
			Status: <? echo $status; ?><br>
			Pobočka: <? echo $user['pobocka']; ?><br>
		</div>
		<br>
		<form action="account.php" method="get">
			<button id="account" class="userButton" type="submit">Správa účtu</button>
		</form>	
		<form action="logout.php" method="get">
			<button id="logout" class="userButton" type="submit">Odhlásit se</button>
		</form>
	</div>
	<?php	
}

// ukonceni stranky o uzivateli
function endAccountPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>



