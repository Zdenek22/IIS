<?php

// funkce pro vytvoreni main page

// usage:	makeMainPage()
//			mainPageButtons()
//			startTable()
//			fillTable($medicine)  -> cyklem projet pro kazdy lek
//			endTable()
//			mainFindBar()
//			userInfo($id)
//			endMainPage()


require_once "DBOperations.php";

//	hlavicka + nadpis
function makeMainPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - hlavní stránka</title>
	</head>
	<body>
		<h1>Lékárna</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}


// vytvoreni tlacitek na leve strane stranky
// Hlavni stranka - id = mainPage
// Seznam rezervaci - id = reservations
// Sklad - id = store
function mainPageButtons(){
	?>	
	<div class="firstCol">
		<div class="menu">
			<form action="main.php" method="get">
				<button id="mainPage" class="menuButtons" type="submit">Hlavní stránka</button>
			</form>
			<form action="reservations.php" method="get">
				<button id="reservations" class="menuButtons" type="submit">Seznam rezervací</button>
			</form>
			<form action="store.php" method="get">	
				<button id="store" class="menuButtons" type="submit">Sklad</button>
			</form>
		</div>
	</div>
	<?php	
}

// vytvori tabulku leku, a zacne prvni radek tabulky
function startTable(){
	?>	
	<div class="secondCol">
		<table class="medTable">
			<tr>
	<?php
}

// naplni jednu bunku tabulky, pokud je treba, vytvori novy radek tabulky
function fillTable($medicine, $newline){
	// je potreba aby pri prvnim pruchodu bylo nastaveno newline na false
	if($newline == true){
		?>
		</tr>
		<tr>
		<?php
	}

	// vytvoreni bunky s lekem
	?>
	<!-- TODO odkazy na spravne stranky, pridat hodnoty z $user, upravit obrazek -->
	<td class="mytd" align="center" valign="center"><img src="bottle.png" style="width: 40%; height: 40%; float: top;"><br><br>
		<button class="medButton">Rezervovat lék!</button>
		<button class="medButton">Vydat lék</button>
		<button class="medButton">Detail léku</button>
		<div class="description">Název:</div>
		<div class="name">Marťánci</div>
		<div class="description">Cena:</div>
		<div class="value">100Kč</div>
		<div class="description">Na skladě:</div>
		<div class="value">100ks</div>
	</td>

	<?php	
}

function endTable(){
	?>
			</tr>	<!-- konec radku tabulky -->
		</table>	<!-- konec tabulky -->
	</div>			<!-- konec secondCol -->
	<?php	
}

// vytvoreni baru pro nalezeni leku a ukonceni stranky
function mainFindBar(){
	// TODO akce pri hledani leku
	?>
	<div class="thirdCol">
		<form action="findMedicine.php" method="get">
			<input class="findItem" type="text" name="findItem" placeholder="Hledej lék">
			<button id="find" class="findButton" type="submit">Hledej</button>
		</form>

	<?php
}

// prida na stranku informace o uzivateli
function userInfo($id){
	$person[0] = 'xrita';
	$person[1] = 'me';
	$server = new Database_access();
	$user = $server->getPerson($person);
	?>	
	<div class="info">
		Uživatel: Pepek Namornik<br>
		login: <?echo $user['login'];?><br>
		Status: správce/zaměstnanec<br>
	</div>
	<br>
	<form action="accountInfo.php" method="get">
		<button id="accountInfo" class="userButton" type="submit">Správa účtu</button>
	</form>	
	<form action="logout.php" method="get">
		<button id="logout" class="userButton" type="submit">Odhlásit se</button>
	</form>
	<?php	
}

function endMainPage(){
	?>	
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>
