<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";
require_once "addemployeepage.php";
require_once "accountinfo.php";

makeAddEmployeePage();
mainPageButtons();
addEmployeeForm();

userAccountInfo();
endAddEmployeePage();
?>
