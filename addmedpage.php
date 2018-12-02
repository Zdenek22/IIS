<?php

// funkce pro vytvoreni stranky pro pridani leku


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeSellPage()
//			mainPageButtons()
//			addEmployeeForm()
//			userAccountInfo()
//			endSellPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeAddMedPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - přidat lék</title>
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

// zobrazi prehled k prodeji leku
function addMedForm(){
	?>
	<div class="secondCol">
		<form action="" method="" id="medform">
			<table style="width: 100%;border: 1px solid #ccc;border-bottom: 0px;">
				<tr>
					<td style="width: 20%;">*ID léku:</td>
					<td style="text-align: left;"><input type="text" name="id" required="required" placeholder="Lek4"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Jméno léku:</td>
					<td style="text-align: left;"><input type="text" name="jmeno" placeholder="Indulona"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Cena (Kč):</td>
					<td style="text-align: left;"><input type="number" name="cena" placeholder="42"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Počáteční množství:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="number" name="amount" placeholder="42"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Pobočka, na které lék bude:</td>
					<td style="text-align: left;"><input list="pobocka" name="pobocka" required="required">
						<datalist id="pobocka">
  							<option value="U Raka">
  							<option value="Španělská">
  							<option value="U Černé bobule">
  							<option value="Babiččina lékárna">
						</datalist></td>
				</tr>
			</table>
		</form>
		<table style="width: 100%;border: 1px solid #ccc;border-top: 0px;">
			<tr>
				<td style="width: 20%;">Popis léku:</td>
				<td style="text-align: left;"><textarea name="popis" form="medform" placeholder="Zadej popis..."></textarea></td>
			</tr>
			<tr>
				<td style="width: 20%;"></td>
				<td style="text-align: center;"><input form="medform" type="submit" name="add" value="Přidat" style="color: white;background-color:#4CAF50;margin-right: 20%;"></td>
			</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
		</table>	
	</div>
	<?php
}


// ukonceni stranky
function endAddMedPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


