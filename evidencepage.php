<?php

// funkce pro vytvoreni stranky pro evidenci transakci


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeEvidencePage()
//			mainPageButtons()
//			startEvidenceTable()
//			fillEvidenceTable($transakce)
//			endEvidenceTable()
//			userAccountInfo()
//			endSellAmountPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeEvidencePage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - evidence transakcí</title>
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



function startEvidenceTable(){
	?>
	<div class="secondCol">
	<table class="evidenceTable">
				<!--cas, kdo, co, komu, pojistovna, kolik	-->	
			<tr>
				<th>Čas vydání</th>
				<th>Vydal</th>
				<th>Rodné číslo zákazníka</th>
				<th>Jméno zákazníka</th>
				<th>Příjmení zákazníka</th>
				<th>Pojišťovna</th>
				<th>Lék</th>
				<th>Množství (ks)</th>
			</tr>
	<?		
}


function fillEvidenceTable($transakce){
	?>	
	<tr>
		<td><?echo $transakce['cas'];?></td>
		<td><?echo $transakce['login'];?></td>
		<td><?echo $transakce['RC'];?></td>
		<td><?echo $transakce['jmeno'];?></td>
		<td><?echo $transakce['prijmeni'];?></td>
		<td><?echo $transakce['pojistovna'];?></td>
		<td><?echo $transakce['lek'];?></td>
		<td><?echo $transakce['kolik'];?></td>
	</tr>	
	<?php
}


function endEvidenceTable(){
	?>
	</table>
	</div>
	<?php
}


// ukonceni stranky
function endSellAmountPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}


function fillSellAgain($fill, $errorMsg, $count, $medicine){
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
				<span class="medDesc">Lék: </span>
				<span class="medVal"><? echo $medicine['jmeno']; ?></span><br>
				<span class="medDesc">Cena: </span>
				<span class="medVal"><? echo $medicine['cena']; ?> Kč</span><br>
				<span class="medDesc">Na předpis: </span>
				<span class="medVal"><? echo $predpis ?></span><br>
				<span class="medDesc">Skladem: </span>
				<span class="medVal"><? echo $medicine['pocet']; ?> Ks</span><br>
				<span class="medDesc">Popis: </span>
				<span class="medVal"><? echo $popis; ?></span>
			</div>
		</div>
		<?php
		if($medicine['predpis'] == 1){
			?>

			<form action="operations.php" method="post">
				<div class="userForm" style="float: left">
					<input type="hidden" name="lek" value=<?echo '"';echo $medicine['jmeno'];echo '"';?>>
					<input type="hidden" name="predpis" value="1">
					<caption>Vyplňte formulář (všechny položky jsou povinné):</caption><br>
					<table style="float: left;">
					<tr>
						<td><span class="formDesc">Jméno</span></td>
						<td><input class="userInput" type="text" name="jmeno" value=<?echo '"';echo $fill['jmeno'];echo '"';?> required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Příjmení</span></td>
						<td><input class="userInput" type="text" name="prijmeni" value=<?echo '"';echo $fill['prijmeni'];echo '"';?> required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Rodné číslo</span></td>
						<td><input class="userInput" type="text" name="RC" value=<?echo '"';echo $fill['RC'];echo '"';?> required="required"></td>
					</tr>
					<tr>
						<td><span class="formDesc">Pojišťovna</span></td>
						<td><input class="userInput" type="text" name="pojistovna" value=<?echo '"';echo $fill['pojistovna'];echo '"';?> required="required"></td>
					</tr>
				</table>			
				</div>
				<table class="amount">
					<tr>
						<td>Množství léku (ks):</td>
						<td><input type="number" name="amount" value="1" min="1"></td>
					</tr>	
				</table>
				<div class="reservMedButtons">
					<input class="resButt" type="submit" name="vydat" value="Vydat lék">
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
		
		<?php
		}
		else{
			?>
			<form action="operations.php" method="post">
				<div class="sellAmount">
					<input type="hidden" name="lek" value=<?echo '"';echo $medicine['jmeno'];echo '"';?>>
					<input type="hidden" name="predpis" value="0">
					<span class="amountDesc">Množství léku (ks):</span>
					<input class="numAmount" type="number" name="amount" value="1" min="1">
					<div class="sellMedButtons">
						<input class="sellAmountButt" type="submit" name="vydat" value="Vydat">
					</div>
				</div>
			</form>	
			<form action="main.php" class="cancForm">
				<input class="cancSellAmountButt" type="submit" name="zrusit" value="Zrušit">			
			</form>
		<?php
		}
		?>
		<br>

		<?php
		foreach ($errorMsg as $key => $value) {
		?>
		<div style="float: left;margin: 4px; width: 100%;">
			<?echo $value;?>
		<br>
		</div>
		<?php
	}
	?>
	</div>		
	<?php			
}

?>



