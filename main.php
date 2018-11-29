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

if(isset($_POST['hledat'])){
	$jmeno=$_POST['hledat'];
}
else{
	$jmeno='';
}

$server = new Database_access();
$medicaments = $server->getMedicament($jmeno, $_SESSION['pobocka']);

$counter = 1;
foreach($medicaments as $key => $value){
	$counter = $counter +1;
	if($counter%3==0)
		fillTable($value, false);
	else
		fillTable($value, true);
}

endTable();
mainFindBar();
userInfo($_SESSION['user']);
endMainPage();
?>
