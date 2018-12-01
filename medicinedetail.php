<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "detailpage.php";
require_once "accountinfo.php";

makeDetailPage();
mainPageButtons();

$server = new Database_access();
$medicament = $server->getMedicament($_GET['lek'], $_SESSION['pobocka']);

showDetail($medicament[0]);
userAccountInfo();
endDetailPage();
?>