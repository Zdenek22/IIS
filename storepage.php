<?php

// funkce pro vytvoreni stranky skladu


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeStorePage()
//			mainPageButtons()
//			startStoreTable()
//			fillStoreTable($medicine)
//			endStoreTable()
//			userAccountInfo()
//			endPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeStorePage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - sklad</title>
	</head>
	<body>
	<?php
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	?>
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?></h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// Vytvori tabulku rezervaci s hlavickovymi vstupy
// $pobocka -> k jake pobocce se rezervace vztahuji
function startStoreTable(){
	?>
		<div class="secondCol">
		<table class="skladTable">
		<tr>
			<th style="border: 1px solid #ccc;border-collapse: collapse;">Název léku</th>
			<th style="border: 1px solid #ccc;border-collapse: collapse;">Množství(ks)</th>
			<th style="border: 1px solid #ccc;border-collapse: collapse;">Přidat množství</th>
			<th style="border: 1px solid #ccc;border-collapse: collapse;">Odebrat množství</th>
		</tr>
	<?php			
}


function fillStoreTable($medicine){
	?>
	<tr>
		<td><?echo $medicine['jmeno'];?></td>
		<td><?echo $medicine['pocet']?></td>
		<td>
			<form>
				<input class="skladAmount" type="number" name="amount" value="1" min="1">
				<input class="pridatButton" type="button" name="Pridat" value="Přidat">
			</form>
		</td>
		<td>
			<form>
				<input class="skladAmount" type="number" name="amount" value="1" min="1">
				<input class="odebratButton" type="button" name="odebrat" value="Odebrat">
			</form>	
		</td>
	</tr>
	<?php	
}

// ukonceni tabulky
function endStoreTable(){
	?>
			</table>
		</div>	
	<?php
}


// ukonceni stranky
function endStorePage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>



