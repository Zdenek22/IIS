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
		<?php
		if($medicine['predpis'] == 1){
			?>

			<form>
				<div class="userForm" style="float: left">
					<caption>Vyplňte formulář (všechny položky jsou povinné):</caption><br>
					<input type="hidden" name="lek" class=<?echo '"';echo $medicine['jmeno'];echo '"';?>>
					<span class="formDesc">Jméno</span>
					<input class="userInput" type="text" name="jmeno" placeholder="Jméno" required="required">
						<br>
					<span class="formDesc">Příjmení</span>
					<input class="userInput" type="text" name="prijmeni" placeholder="Příjmení" required="required">
						<br>
					<span class="formDesc">Rodné číslo</span>
					<input class="userInput" type="text" name="RC" placeholder="959959448" required="required">
						<br>	
					<span class="formDesc">Pojišťovna</span>
					<input class="userInput" type="text" name="pojistovna" placeholder="Pojišťovna" required="required">
						<br>			
				</div>
				<div class="amount">
					<span class="amountDesc">Množství léku (ks):</span>
					<input class="numAmount" type="number" name="amount" value="1" min="1">		
				</div>
				<div class="reservMedButtons">
					<input class="resButt" type="submit" name="vydat" value="Vydat lék">
				</div>
			</form>	
			<form action="main.php">
				<input class="cancButt2" type="submit" name="zrusit" value="Zrušit">			
			</form>
		</div>
		<?php
		}
		else{
			?>
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
		?>			
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



