<?php

// funkce pro vytvoreni stranky pro vytvoreni rezervace leku


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeMakeReservPage()
//			mainPageButtons()
//			showMedicine($medicine)
//			userAccountInfo()
//			endMakeReservPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeMakeReservPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - vytvořit rezervaci</title>
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

// Vytvori formular pro rezervovani leku na predpis
function showMedicine($medicine){
	$predpis = -1;
	if($medicine['predpis'] == 1)
		$predpis = "Ano";
	else
		$predpis = "Ne";

	$popis = "";
	if(isset($medicine['popis']))
		$popis = $medicine['popis'];		
	?>	
	<div class="secondCol">
		<div class="medicineInfo">
			<img src="bottle.png" style="width: 20%; height: 20%; float: left;">
			<div class="text">
				<span class="medDesc">Lek: </span>
				<span class="medVal"><? echo $medicine['jmeno']; ?></span><br>
				<span class="medDesc">Cena: </span>
				<span class="medVal"><? echo $medicine['cena']; ?></span><br>
				<span class="medDesc">Na předpis: </span>
				<span class="medVal"><? echo $predpis ?></span><br>
				<span class="medDesc">Skladem: </span>
				<span class="medVal"><? echo $medicine['pocet']; ?></span><br>
				<span class="medDesc">Popis: </span>
				<span class="medVal"><? echo $popis; ?></span>
			</div>
		</div>	
		<form action="reservationProceed.php" method="post">
			<div class="userForm" style="float: left">
				<caption>Vyplňte formulář (všechny položky jsou povinné):</caption><br>
				<input type="hidden" name="lek" value=<?echo '"';echo $medicine['jmeno'];echo '"';?>>

				<table style="float: left;">
					<tr>
						<td><span class="formDesc">Jméno</span></td>
						<td><input class="userInput" type="text" name="jmeno" placeholder="Jméno" required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Příjmení</span></td>
						<td><input class="userInput" type="text" name="prijmeni" placeholder="Příjmení" required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Rodné číslo</span></td>
						<td><input class="userInput" type="text" name="RC" placeholder="9605064084" required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Pojišťovna</span></td>
						<td><input class="userInput" type="text" name="pojistovna" placeholder="Pojišťovna" required="required"></td>
					</tr>
				</table>	
			</div>
			<table class="amount">
				<tr>
					<td>Množství léku (ks):</td>
					<td><input type="number" name="amount" value="1" min="1"></td>
				</tr>	
				<tr>
					<td>Vyberte pobočku:</td>
					<td>
						<input list="pobocka" name="pobocka" required="required">
						<datalist id="pobocka">
  							<option value="U Raka">
  							<option value="Španělská">
  							<option value="U Černé bobule">
  							<option value="Babiččina lékárna">
						</datalist>
  					</td>
				</tr>
			</table>
			<div class="reservMedButtons">
				<input class="resButt" type="submit" name="rezervovat" value="Rezervovat">
			</div>
		</form>
		<form action="main.php">
			<table class="helpTable">
				<tr>
					<td style="width: 80%;"></td>
					<td><input class="cancButt" type="submit" name="zrusit" value="Zrušit"><td>
				</tr>	
			</table>			
		</form>
	</div>		
	<?php			
}

// ukonceni stranky
function endMakeReservPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>



