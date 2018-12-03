<?php

// funkce pro vytvoreni stranky pro seznam zamestnancu


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeEmployeeListPage()
//			mainPageButtons()
//			startEmployeeListTable()
//			fillEmployeeListTable($transakce)
//			endEmployeeListTable()
//			userAccountInfo()
//			endEmployeeListPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeEmployeeListPage(){
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
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Seznam zaměstnanců</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}



function startEmployeeListTable(){
	?>
	<div class="secondCol">
	<table style="width: 100%;border: 1px solid #ccc; border-collapse: collapse;">
				<!--cas, kdo, co, komu, pojistovna, kolik	-->	
			<tr>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Login</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Jméno</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Příjmení</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Telefon</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Email</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Postavení</th>
				<th style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;">Pracuje na pobočce</th>
			</tr>
	<?php		
}


function fillEmployeeListTable($employee){
	if(!isset($employee['telefon'])){
		$employee['telefon'] = "N/A";
	}
	if(!isset($employee['email'])){
		$employee['email'] = "N/A";
	}
	$postaveni;
	if($employee['postaveni'] == '0')
		$postaveni = "Zaměstnanec";
	else
		$postaveni = "Správce";
	?>	
	<tr>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['login'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['jmeno'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['prijmeni'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['telefon'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['email'];?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $postaveni;?></td>
		<td style="border-collapse: collapse;text-align: center;border: 1px solid #ccc;"><?echo $employee['pobocka'];?></td>
	</tr>	
	<?php
}


function endEmployeeListTable(){
	?>
	</table>
	</div>
	<?php
}


// ukonceni stranky
function endEmployeeListPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}

