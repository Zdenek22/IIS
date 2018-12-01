<?php

// funkce pro vytvoreni reserv page


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeReservPage()
//			mainPageButtons()
//			startReservTable()
//			fillReservTable($id)  -> cyklem projet pro kazdou rezervaci
//			endTable()
//			reservFindBar()
//			userInfo($id)
//			endReservPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeReservPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - rezervace</title>
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
function startReservTable(){
	?>
	<div class="secondCol">
		<table class="reserTable">
			<tr>
				<th class="reserValues">Číslo rezervace</th>
				<th class="reserValues">Vytvořil</th>
				<th class="reserValues">Rodné číslo</th>
				<th class="reserValues">Pojišťovna</th>
				<th class="reserValues">Pobočka</th>
				<th class="reserValues">Rezervovaný lék</th>
				<th class="reserValues">Množství(ks)</th>
				<th class="reserValues">Cena(Kč)</th>
				<th class="reserValues">Vydat</th>
				<th class="reserValues">Zrušit</th>
			</tr>
	<?php			
}

// naplni jeden radek tabulky rezervaci (pokud vice leku rezervovano -> rowspan)
// $count -> pocet ruznych typu leku v jedne rezervaci
// $reserv -> informace o jedne rezervaci (cislo rezervace, info o zakaznikovi)
// $medicine -> pole leku, ktere si zakaznik objednal
function fillReservTable($count, $reserv, $medicine){
/*
	pocet - ruznych leku
	reserv - pole, v nem ID, Vytvoril, Pojistovna, Rodne cislo, Jmeno pobocky
	medicine - pole poli, prvni pole je == count-1, druhe pole ma rezervace(cena), lek(jmeno) a pocet(mnozstvi)
	$server = new Database_access();
	$reserv = $server->getInformation($id);*/
	echo "<tr>";
	echo "<td rowspan=";echo '"';;echo $count;echo '"';echo ' class="reserValues"';echo ">";echo $reserv['id'];echo "</td>";
	echo "<td rowspan=";echo '"';echo $count;echo '"';echo ' class="reserValues"';echo ">";echo $reserv['vytvoril'];echo "</td>";
	echo "<td rowspan=";echo '"';echo $count;echo '"';echo ' class="reserValues"';echo ">";echo $reserv['RC'];echo "</td>";
	echo "<td rowspan=";echo '"';echo $count;echo '"';echo ' class="reserValues"';echo ">";echo $reserv['pojistovna'];echo "</td>";
	echo "<td rowspan=";echo '"';echo $count;echo '"';echo ' class="reserValues"';echo ">";echo $reserv['jmeno'];echo "</td>";

	$i = 0;

	foreach ($medicine as $i => $value) {
		?>
		<td class="reserValues"><? echo $value['lek']; ?></td>
		<td class="reserValues"><? echo $value['pocet']; ?></td>
		<td class="reserValues"><? echo $value['rezervace']; ?></td>
		<?php
		if($i == 0){
			echo "<td rowspan=";echo '"';echo $count;echo '"';echo ">";
			?>
				<form action="operations.php" method="get">	
					<input type="hidden" name="id" value=<?echo '"';echo $reserv['id'];echo '"';?>>
					<input class="giveButton" type="submit" name="reservation" value="Vydej">
				</form>
			</td>
			<?php
			echo "<td rowspan=";echo '"';echo $count;echo '"';echo ">";
			?>
				<form action="operations.php" method="get">
					<input type="hidden" name="id" value=<?echo '"';echo $reserv['id'];echo '"';?>>
					<input class="cancelButton" type="submit" name="reservation" value="Storno">
				</form>
			</td>
			</tr>
			<?php
		}
		else{
			?>
			</tr>
			<?php
		}
		$i = $i + 1;
	}
}

// bar pro hledani rezervaci
function reservFindBar(){
	?>
	<div class="thirdCol">
		<caption style="float: left;">Najdi rezervaci:</caption>
		<form action="reservations.php" method="get">
			<input class="findItem" type="text" name="hledat" placeholder="Číslo rezervace">
			<button id="find" class="findButton" type="submit">Hledej</button>
		</form>
	<?php
}

// ukonceni stranky s rezervacemi
function endReservPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>



