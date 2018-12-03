<?
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";
require_once "sellpage.php";
require_once "mainpage.php";
require_once "accountinfo.php";
require_once "evidencepage.php";
require_once "changevaluespage.php";

makeChangePage();
mainPageButtons();

if(isset($_POST['error'])){
	changeHeslo(1);
}


if(isset($_GET['changeTelefon'])){
	changeTelefon();
}
elseif (isset($_GET['changeEmail'])) {
	changeEmail();
}
elseif (isset($_GET['changeHeslo'])) {
	changeHeslo(0);
}

userAccountInfo();
endChangePage();