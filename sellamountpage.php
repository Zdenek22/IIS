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
					<caption>Vyplňte formulář (všechny položky jsou povinné):</caption><br>
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

			<form>
				<div class="userForm" style="float: left">
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
		?>			
	<?php			
}

?>



