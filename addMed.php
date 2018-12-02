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
addMedForm();
userAccountInfo();
endAddMedPage();
?>
