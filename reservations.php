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

if(isset($_GET['hledat'])){
	$jmeno=$_GET['hledat'];
}
else{
	$jmeno='';
}
echo "pobocka $_SESSION[pobocka]";
vypisRezervace($_SESSION['pobocka']);

endTable();
reservFindBar();
userInfo($_SESSION['user']);
endReservPage();
?>
