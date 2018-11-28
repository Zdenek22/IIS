<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";
require_once "DBOperations.php";

checkNsetLogin();

makeMainPage();
mainPageButtons();
startTable();

$server = new Database_access();
$person = $server->getInformation($_SESSION['user']);
echo($_SESSION['user']);
foreach($person as $key => $value){
	//if($key === "pobocka" or $key === 2)
	//	$value=$server->getPobockaName($value);

	echo "$key je $value aa<br>";
}

fillTable('xrita', false);
endTable();
mainFindBar();
userInfo('xrita');
endMainPage();
?>
