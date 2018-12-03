<?php

// funkce pro vytvoreni stranky pro pridani nove pobocky


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeAddPobockaPage()
//			mainPageButtons()
//			addPobockaForm()
//			userAccountInfo()
//			endPobockaPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeAddPobockaPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - přidat pobočku</title>
	</head>
	<body>
	<?php
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	?>
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Přidat pobočku</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// zobrazi prehled k prodeji leku
function addPobockaForm(){
	?>
	<div class="secondCol">
		<form action="operations.php" method="post">
			<table style="width: 100%;border: 1px solid #ccc;">
				<tr>
					<td style="width: 20%;">*Jméno pobočky:</td>
					<td style="text-align: left;"><input type="text" required="required" name="jmeno" placeholder="Pobočka"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Město:</td>
					<td style="text-align: left;"><input type="text" required="required" name="mesto" placeholder="Město"></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Ulice:</td>
					<td style="text-align: left;"><input type="text" name="ulice" placeholder="Ulice"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Číslo domu:</td>
					<td style="text-align: left;"><input type="number" required="required" name="cislo" min="1" placeholder="1"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*PSČ:</td>
					<td style="text-align: left;"><input type="number" required="required" name="psc" placeholder="66666" pattern="[0-9]{5}"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Peníze na pobočce (Kč):</td>
					<td style="text-align: left;"><input type="number" required="required" name="penize" min="1" placeholder="1">
					</td>
				</tr>
				<tr>
					<td style="width: 20%;"></td>
					<td style="text-align: center;"><input type="submit" name="addPobocka" value="Přidat" style="color: white;background-color:#4CAF50;margin-right: 20%;"></td>
				</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
			</table>
		</form>	
	</div>
	<?php
}


// ukonceni stranky
function endAddPobockaPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


