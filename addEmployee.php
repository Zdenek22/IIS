<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "addemployeepage.php";
require_once "accountinfo.php";

checkNsetLogin();

makeAddEmployeePage();
mainPageButtons();


if(isset($_POST['login'])){

	$fill;
	$errorMsg[0] = "";
	$count = 0;

	$fill['login'] = $_POST['login'];
	$fill['jmeno'] = $_POST['jmeno'];
	if(isset($_POST['telefon'])){
		$fill['telefon'] = $_POST['telefon'];
	}
	else{
		$fill['telefon'] = "";
	}
	if(isset($_POST['email'])){
		$fill['email'] = $_POST['email'];		
	}
	else{
		$fill['email'] = "";
	}

	$fill['prijmeni'] = $_POST['prijmeni'];
	$fill['pobocka'] = $_POST['pobocka'];

	if($_POST['login'] == '0'){
		$fill['login'] = "";
		$errorMsg[$count] = "Zadaný login již existuje! Zadejte jiný.";
		$count = $count + 1;
	}
	if($_POST['jmeno'] == '0'){
		$fill['jmeno'] = "";
		$errorMsg[$count] = 'Špatný formát jména!';
		$count = $count + 1;
	}
	if($_POST['prijmeni'] == '0'){
		$fill['prijmeni'] = "";
		$errorMsg[$count] = "Špatný formát příjmení! Zadejte znovu.";
		$count = $count + 1;
	}

	fillEmployeeAgain($fill, $errorMsg, $count);
}

else{
	addEmployeeForm();
}

userAccountInfo();
endAddEmployeePage();
?>
