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

$reservations = $server->getReservations($_SESSION['pobocka']);
echo "juhu $_SESSION[pobocka] huu";
foreach ($reservations as $key => $value) {
	$leky = $server->getMedsInReservation($value['id']);
	$pocet = count($leky);
	$counter = 0;
	foreach ($leky as $keyy => $valuee) {
		$cena = $server->getMedsValue($valuee['lek']);
		$leky[$counter]['rezervace'] = $cena;
		$leky[$counter]['lek'] = $server->getMedsName($valuee['lek']);
		$counter = $counter+1;
	}
	foreach ($leky as $key => $value) {
		echo "$key je $value <br>";
		foreach ($value as $keyy => $valuee) {
			echo "$keyy je $valuee <br>";}
	}
	
}


endTable();
mainFindBar();
userInfo($_SESSION['user']);
endMainPage();
?>
