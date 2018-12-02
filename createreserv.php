<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "makereservpage.php";
require_once "accountinfo.php";

makeMakeReservPage();
mainPageButtons();


if(isset($_POST['lek'])){

	$fill;
	$errorMsg;
	$count = 0;
	$server = new Database_access();
	$jmeno = $server->getMedsName($_POST['lek']);
	$medicament = $server->getMedicament($jmeno, $_SESSION['pobocka']);

	$fill['jmeno'] = $_POST['jmeno'];
	$fill['prijmeni'] = $_POST['prijmeni'];
	$fill['RC'] = $_POST['RC'];
	$fill['pojistovna'] = $_POST['pojistovna'];
	$fill['pobocka'] = $_POST['pobocka'];

	if($_POST['jmeno'] == '0'){
		$fill['jmeno'] = "";
		$errorMsg[$count] = 'Špatný formát jména!';
		$count = $count + 1;
	}
	if($_POST['prijmeni'] == '0'){
		$fill['prijmeni'] = "";
		$errorMsg[$count] = "Špatný formát příjmení! Zadejte znovu";
		$count = $count + 1;
	}
	if($_POST['RC'] == '0'){
		$fill['RC'] = "";
		$errorMsg[$count] = "Špatný formát rodného čísla! Zadejte znovu";
		$count = $count + 1;
	}	
	elseif ($_POST['RC'] == '1') {
		$fill['RC'] = "";
		$fill['jmeno'] = $_POST['jmeno'];
		$prijmeni['prijmeni'] = $_POST['prijmeni'];
		$errorMsg[$count] = "Zadané rodné číslo odpovídá jinému člověku!";
		$count = $count + 1;
	}
	if($_POST['pojistovna'] == '0'){
		$fill['pojistovna'] = "";
		$errorMsg[$count] = "Zadaná pojišťovna neexistuje! Zadejte znovu.";
		$count = $count + 1;
	}
	if($_POST['pobocka'] == '0'){
		$fill['pobocka'] = "";
		$errorMsg[$count] = "Zadaná pobočka neexistuje! Zadejte znovu.";
		$count = $count + 1;
	}

	fillAgain($fill, $errorMsg, $count, $medicament[0]);
}

else{
	$server = new Database_access();
	$medicament = $server->getMedicament($_GET['lek'], $_SESSION['pobocka']);
	showMedicine($medicament[0]);
}

userAccountInfo();
endMakeReservPage();
?>
