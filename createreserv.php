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

$server = new Database_access();
$medicament = $server->getMedicament($_GET['lek'], $_SESSION['pobocka']);

showMedicine($medicament[0]);
userAccountInfo();
endMakeReservPage();
?>