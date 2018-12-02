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
		<form action="operations.php" method="post">
			<table style="width: 100%;border: 1px solid #ccc;">
				<tr>
					<td style="width: 20%;">*Login zaměstnance:</td>
					<td style="text-align: left;"><input type=text name="login" required="required" placeholder="xlogin"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Heslo zaměstnance:</td>
					<td style="text-align: left;"><input type="password" name="heslo" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Jméno zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="jmeno" placeholder="Jméno" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Příjmení zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="prijmeni" placeholder="Příjmení" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Telefon zaměstnance:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="tel" name="telefon" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" placeholder="909090909"></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Email zaměstnance:</td>
					<td style="text-align: left;"><input type="email" name="email" placeholder="xlogin@gmail.com"></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Postavení zaměstnance:</td>
					<td style="text-align: left;"><select list="postaveni" name="postaveni" required="required" style="width: 20%;">
						<datalist id="postaveni">
							<option value="0">Zaměstnanec</option>
							<option value="1">Správce</option>
						</datalist>
					</td>	
				</tr>
				<tr>
					<td style="width: 20%;">*Pobočka, na které bude pracovat:</td>
					<td style="text-align: left;"><select list="pobocka" name="pobocka" required="required" style="width: 20%;">
						<datalist id="list">
								<?php
								$server = new Database_access();
								$pobo = $server->getAllPobocka();
								foreach ($pobo as $key => $value) {
						 			?>
						 			<option><?echo $value['jmeno'];?></option>
						 			<?php
						 		} 
								?>	
							</datalist>
							</td>
				</tr>
				<tr>
					<td style="width: 20%;"></td>
					<td style="text-align: center;"><input type="submit" name="addEmp" value="Přidat" style="color: white;background-color: #4CAF50;margin-right: 20%;"></td>
				</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
			</table>
		</form>	
	</div>
	<?php
}


function fillEmployeeAgain($employee, $errorMsg, $count){
	?>
	<div class="secondCol">
		<form action="operations.php" method="post">
			<table style="width: 100%;border: 1px solid #ccc;">
				<tr>
					<td style="width: 20%;">*Login zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="login" required="required" placeholder="xlogin" value=<?echo '"';echo $employee['login'];echo '"';?>></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Heslo zaměstnance:</td>
					<td style="text-align: left;"><input type="password" name="heslo" required="required"></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Jméno zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="jmeno" placeholder="Jméno" required="required" value=<?echo '"';echo $employee['jmeno'];echo '"';?>></td>
				</tr>
				<tr>
					<td style="width: 20%;">*Příjmení zaměstnance:</td>
					<td style="text-align: left;"><input type="text" name="prijmeni" placeholder="Příjmení" required="required" value=<?echo '"';echo $employee['prijmeni'];echo '"';?>></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Telefon zaměstnance:</td>
					<td style="text-align: left;" style="text-align: left;"><input type="tel" name="telefon" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" placeholder="909090909" value=<?echo '"';echo $employee['telefon'];echo '"';?>></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Email zaměstnance:</td>
					<td style="text-align: left;"><input type="email" name="email" placeholder="xlogin@gmail.com" value=<?echo '"';echo $employee['email'];echo '"';?>></td>
				</tr>
				<tr>
					<td style="width: 20%;"> Postavení zaměstnance:</td>
					<td style="text-align: left;"><select list="postaveni" name="postaveni" required="required" style="width: 20%;">
						<datalist id="postaveni">
							<option value="0">Zaměstnanec</option>
							<option value="1">Správce</option>
						</datalist>
					</td>	
				</tr>
				<tr>
					<td style="width: 20%;">*Pobočka, na které bude pracovat:</td>
					<td style="text-align: left;"><select list="pobocka" name="pobocka" required="required" style="width: 20%;">
						<datalist id="list">
								<?php

								$server = new Database_access();
								$pobo = $server->getAllPobocka();
								foreach ($pobo as $key => $value) {
						 			?>
						 			<option><?echo $value['jmeno'];?></option>
						 			<?php
						 		} 
								?>	
							</datalist>
							</td>
				</tr>
				<tr>
					<td style="width: 20%;"></td>
					<td style="text-align: center;"><input type="submit" name="addEmp" value="Přidat" style="color: white;background-color: #4CAF50;margin-right: 20%;"></td>
				</tr>
				<tr>
					<td style="width: 20%">* - pole je povinné</td>
				</tr>
			</table>
		</form>	
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





// ukonceni stranky
function endAddEmployeePage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


