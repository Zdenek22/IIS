<?php

// funkce pro vytvoreni stranky pro vyber mnozstvi leku na vydej


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeSellAmountPage()
//			mainPageButtons()
//			amountToSell($medicine)
//			userAccountInfo()
//			endSellAmountPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeSellAmountPage(){
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

// Vytvori formular pro vyber mnozstvi
function amountToSell($medicine){
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
		<form>
			<div class="sellAmount">
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
?>



