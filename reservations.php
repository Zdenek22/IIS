<?php
session_save_path("./tmp");
session_start();

require_once "mainpage.php";
require "supFunct.php";
require "reservpage.php";
require_once "DBOperations.php";

checkNsetLogin();

makeReservPage();
mainPageButtons();
startReservTable();

if(isset($_GET['hledej'])){
	$jmeno=$_GET['hledej'];
}
else{
	$jmeno='';
}

vypisRezervace($_SESSION['pobocka'], $jmeno);
if(isset($_GET['rezervation']))
	endTable("Chybí dostatečné množství medikamentů na prodejně.");
else
	endTable();
reservFindBar();
userInfo($_SESSION['user']);
endReservPage();
?>
