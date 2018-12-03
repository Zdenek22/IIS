<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "accountinfo.php";

checkNsetLogin();

makeAccountPage();
mainPageButtons();
startAccountTable();
fillAccountTable();
endAccountTable();
userAccountInfo();
endAccountPage();
?>
