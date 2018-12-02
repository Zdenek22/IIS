<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "addmedpage.php";
require_once "accountinfo.php";

makeAddMedPage();
mainPageButtons();

if(isset($_POST['login'])){

	$fill;
	$errorMsg[0] = "";
	$count = 0;

	$fill['jmeno'] = "";
	$fill['cena'] = $_POST['cena'];
	$fill['amount'] = $_POST['amount'];
	if(isset($_POST['popis']))
		$fill['popis'] = $_POST['popis'];
	else
		$fill['popis'] = "";
	Again($fill);
}

else{
	addMedForm();
}
userAccountInfo();
endAddMedPage();
?>
