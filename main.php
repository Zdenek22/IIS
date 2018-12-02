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

if(isset($_GET['hledat'])){
	$jmeno=$_GET['hledat'];
}
else{
	$jmeno='';
}

$server = new Database_access();
$medicaments = $server->getMedicament($jmeno, $_SESSION['pobocka']);

$counter = 0;
foreach($medicaments as $key => $value){
	if($counter%3==0)
		if($counter == 0)
			fillTable($value, false);
		else
			fillTable($value, true);
	else
		fillTable($value, false);
	$counter = $counter +1;
}



endTable(0);
mainFindBar();
userInfo($_SESSION['user']);
endMainPage();
?>
