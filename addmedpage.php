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
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Přidat lék</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// zobrazi prehled k prodeji leku
function addMedForm(){
	?>
	<div class="secondCol">
		<form action="operations.php" method="post" id="medform">
			<table style="width: 100%;border: 1px solid #ccc;border-bottom: 0px;">
				<tr>
					<td style="width: 20%;">*Jméno léku:</td>
					<td style="text-align: left;"><input type="text" name="jmeno" required="required" placeholder="Indulona"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Cena (Kč):</td>
					<td style="text-align: left;"><input type="number" name="cena" required="required" value="1" min="1"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Počáteční množství:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="number" name="amount" required="required" value="1" min="0"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Na předpis:</td>
					<td style="text-align: left;" style="text-align: left;"><select list="predpis" name="predpis" required="required" style="width: 20%;">
						<datalist id="predpis">
							<option value="0">Ne</option>
							<option value="1">Ano</option>
						</datalist>
						</select>
					</td>
				</tr>
			</table>
		<table style="width: 100%;border: 1px solid #ccc;border-top: 0px;">
			<tr>
				<td style="width: 20%;"> Popis léku:</td>
				<td style="text-align: left;"><textarea name="popis" form="medform" placeholder="Zadej popis..."></textarea></td>
			</tr>
			<tr>
				<td style="width: 20%;"></td>
				<td style="text-align: center;"><input form="medform" type="submit" name="addMed" value="Přidat" style="color: white;background-color:#4CAF50;margin-right: 20%;"></td>
			</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
		</table>
		</form>	
	</div>
	<?php
}

function Again($fill){
	?>

	<div class="secondCol">
		<form action="operations.php" method="post" id="medform">
			<table style="width: 100%;border: 1px solid #ccc;border-bottom: 0px;">
				<tr>
					<td style="width: 20%;">*Jméno léku:</td>
					<td style="text-align: left;"><input type="text" name="jmeno" required="required" placeholder="Indulona"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Cena (Kč):</td>
					<td style="text-align: left;"><input type="number" name="cena" required="required" value=<?echo '"';echo $fill['cena'];echo '"';?> min="1"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Počáteční množství:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="number" name="amount" required="required" value=<?echo '"';echo $fill['amount'];echo '"';?> min="0"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Na předpis:</td>
					<td style="text-align: left;" style="text-align: left;"><select list="predpis" name="predpis" required="required" style="width: 20%;">
						<datalist id="predpis">
							<option value="0">Ne</option>
							<option value="1">Ano</option>
						</datalist>
						</select>
					</td>
				</tr>
			</table>
		<table style="width: 100%;border: 1px solid #ccc;border-top: 0px;">
			<tr>
				<td style="width: 20%;"> Popis léku:</td>
				<td style="text-align: left;"><textarea name="popis" form="medform" placeholder="Zadej popis..."><?echo $fill['popis']?></textarea></td>
			</tr>
			<tr>
				<td style="width: 20%;"></td>
				<td style="text-align: center;"><input form="medform" type="submit" name="addMed" value="Přidat" style="color: white;background-color:#4CAF50;margin-right: 20%;"></td>
			</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
		</table>
		</form>	
		<br>
		<div style="float: left;">Zadaný lék již existuje!</div>
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


