<?php

// funkce pro vytvoreni stranky skladu


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeDetailReservPage()
//			mainPageButtons()
//			reservDetail($count, $reserv, $medicine)
//			endTable()
//			userAccountInfo()
//			endReservDeatilPage()


require_once "DBOperations.php";
require_once "reservpage.php";
require_once "mainpage.php";
require_once "reservpage.php";



// zacatek stranky s rezervacemi
function makeDetailReservPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - detail rezervace</title>
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



function reservDetail($count, $reserv, $medicine){

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
				<th class="reserValues">Uložit</th>
				<th class="reserValues">Přidat lék</th>
				<th class="reserValues">Zrušit</th>
			</tr>
	<?php

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
					<input class="giveButton" type="button" name="saveReserv" value="Uložit">
				</form>
			</td>
			<?php
			echo "<td rowspan=";echo '"';echo $count;echo '"';echo ">";
			?>
				<form>
					<input class="giveButton" type="button" name="add" value="Přidat lék">
				</form>
			</td>
			<?php
			echo "<td rowspan=";echo '"';echo $count;echo '"';echo ">";
			?>
				<form action="operations.php" method="get">
					<input class="cancelButton" type="button" name="cancelReserv" value="Zrušit">
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


// ukonceni stranky
function endReservDetailPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


