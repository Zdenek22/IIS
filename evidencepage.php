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
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Evidence transakcí</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}



function startEvidenceTable(){
	?>
	<div class="secondCol">
	<table style="width: 100%;border: 1px solid #ccc; border-collapse: collapse;">
				<!--cas, kdo, co, komu, pojistovna, kolik	-->	
			<tr>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Čas vydání</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Vydal</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Rodné číslo zákazníka</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Jméno zákazníka</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Příjmení zákazníka</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Pojišťovna</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Lék</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Množství (ks)</th>
			</tr>
	<?		
}


function fillEvidenceTable($transakce){
	?>	
	<tr>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['cas'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['login'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['RC'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['jmeno'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['prijmeni'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['pojistovna'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['lek'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $transakce['kolik'];?></td>
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
