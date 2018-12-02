<?php

// funkce pro vytvoreni stranky pro pridani zamestnance


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeSellPage()
//			mainPageButtons()
//			addEmployeeForm()
//			userAccountInfo()
//			endSellPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeAddEmployeePage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - přidat zaměstnance</title>
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
function addEmployeeForm(){
	?>
	<div class="secondCol">
		<form action="" method="">
			<table style="width: 100%;border: 1px solid #ccc;">
				<tr>
					<td style="width: 20%;">*Login zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="login" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Jméno zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="jmeno"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Příjmení zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="prijmeni"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Telefon zaměstnance:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="text" name="telefon"></td>
				</tr>
				<tr>
					<td style="width: 20%;">Email zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="email"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Pobočka, na které bude pracovat:</td>
					<td style="text-align: left;"><input list="pobocka" name="pobocka" required="required">
						<datalist id="pobocka">
  							<option value="U Raka">
  							<option value="Španělská">
  							<option value="U Černé bobule">
  							<option value="Babiččina lékárna">
						</datalist></td>
				</tr>
				<tr>
					<td style="width: 20%;"></td>
					<td style="text-align: center;"><input type="submit" name="add" value="Přidat" style="color: white;background-color: #4CAF50;margin-right: 20%;"></td>
				</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
			</table>
		</form>	
	</div>
	<?php
}


// ukonceni stranky
function endAddEmployeePage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


