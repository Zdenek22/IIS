<?php

// funkce pro vytvoreni stranky pro pridani nove pobocky


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeAddPobockaPage()
//			mainPageButtons()
//			addPobockaForm()
//			userAccountInfo()
//			endPobockaPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeAddPobockaPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - přidat pobočku</title>
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
function addPobockaForm(){
	?>
	<div class="secondCol">
		<form action="" method="">
			<table style="width: 100%;border: 1px solid #ccc;">
				<tr>
					<td style="width: 20%;">*Jméno pobočky:</td>
					<td style="text-align: left;"><input type="text" name="id" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;"></td>
					<td style="text-align: center;"><input form="medform" type="submit" name="add" value="Přidat" style="color: white;background-color:#4CAF50;margin-right: 20%;" required="required"></td>
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
function endAddPobockaPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


