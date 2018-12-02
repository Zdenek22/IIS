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
	<?php
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	?>
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?></h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// vytvoreni tlacitek na leve strane stranky
function mainPageButtons(){
	?>	
	<div class="firstCol">
		<div class="menu">
			<form action="main.php" method="get">
				<button id="mainPage" class="menuButtons" type="submit" style="margin-top: 0;">Hlavní stránka</button>
			</form>
			<form action="reservations.php" method="get">
				<button id="reservations" class="menuButtons" type="submit">Seznam rezervací</button>
			</form>
			<form action="store.php" method="get">	
				<button id="store" class="menuButtons" type="submit">Sklad</button>
			</form>
			<?php
				if(isset($_COOKIE['tmp_rezervace'])){
					?>
					<form action="detailReserv.php" method="get">	
						<button id="store" class="menuButtons" type="submit">Aktuální rezervace</button>
					</form>
					<?php
				}
			?>

			<?php
			$server = new Database_access();
			$user = $server->getInformation($_SESSION['user']);

			// pokud je spravce
			if($user['postaveni'] == 1){
				?>
				<form action="addEmployee.php" method="get">
					<button style="margin-top: 100px;" class="menuButtons" type="submit">Přidat zaměstnance</button>	
				</form>
				<form action="addMed.php">
					<button class="menuButtons" type="submit">Přidat nový lék</button>
				</form>
				<form action="addPobocka.php">
					<button class="menuButtons" type="submit">Přidat pobočku</button>
				</form>
				<form action="evidence.php">
					<button class="menuButtons" type="submit">Evidence transakcí</button>
				</form>
				<?php
			}
			?>
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
	<td class="mytd" align="center" valign="center"><img src="bottle.png" style="width: 40%; height: 40%; float: top;"><br><br>
	<?php
	
	$predpis = -1;
	if($medicine['predpis'] == 1){
		$predpis = "Ano";
		?>
		<form action="createreserv.php" method="get">
			<button name="lek" class="medButton" <?echo "value=";echo '"';echo $medicine['jmeno'];echo '"';?>>Rezervovat lék!</button>
			</form>
		<?php
	}
	else{
		$predpis = "Ne";
	}
	?>
		<form action="sellamount.php" method="get">
			<button name="lek" class="medButton" <?echo "value=";echo '"';echo $medicine['jmeno'];echo '"';?>>Vydat lék</button>
		</form>
		<form action="medicinedetail.php" method="get">
			<button class="medButton" name="lek" <? echo "value=";echo '"';echo $medicine['jmeno'];echo '"'; ?>>Detail léku</button>
		</form>
		<div class="description">Název:</div>
		<div class="name"><? echo $medicine['jmeno']; ?></div>
		<div class="description">Cena:</div>
		<div class="value"><? echo $medicine['cena']; ?> Kč</div>
		<div class="description">Skladem:</div>
		<div class="value"><? echo $medicine['pocet']; ?> Ks</div>
		<div class="description">Předpis:</div>
		<div class="value"><? echo $predpis ?></div>
	</td>
	<?php	
}

function endTable($msg){
	?>
			</tr>	<!-- konec radku tabulky -->
		</table>	<!-- konec tabulky -->
		<?php 
			if(!($msg === 0)){
				?>
				<br>
				<div style="float: left;"><?echo $msg;?></div>
				<?php
			}	
		?>
	</div>			<!-- konec secondCol -->
	<?php	
}

// vytvoreni baru pro nalezeni leku a ukonceni stranky
function mainFindBar(){
	// TODO akce pri hledani leku
	?>
	<div class="thirdCol">
		<caption style="float: left;">Najdi lék:</caption>
		<form action="main.php" method="get">
			<input class="findItem" type="text" name="hledat" placeholder="Hledej lék">
			<button id="find" class="findButton" type="submit">Hledej</button>
		</form>
	<?php
}

// prida na stranku informace o uzivateli
function userInfo($id){
	$server = new Database_access();
	$user = $server->getInformation($id);
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
	<div class="info">
		Uživatel: <? echo $user['jmeno'];echo " "; echo $user['prijmeni']; ?><br>
		Login: <? echo $_SESSION['user']; ?><br>
		Email: <? echo $mail; ?><br>
		Telefon: <? echo $phone; ?><br>
		Status: <? echo $status; ?><br>
		Pobočka: <? echo $user['pobocka']; ?><br>
		<?php
		if($user['postaveni'] == 1){
			?>
			Peněz na pobočce: <?echo "xxx";?> Kč<br>
			<?php
		}
		?>
	</div>
	<br>
	<form action="account.php" method="get">
		<button id="account" class="userButton" type="submit">Správa účtu</button>
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
