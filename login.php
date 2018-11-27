<?php

session_save_path("./tmp");
session_start();
require "invalidLogin.php";
require "DBOperations.php";
require "supFunct.php";
if((!isset($_POST['user']))or (!isset($_POST['psw']))){
	invalidLoginPage();
	die();
}

$loginData[0] = $_POST['user'];
$loginData[1] = $_POST['psw'];

$server = new Database_access();
$person = $server->getPerson($loginData);

if(empty($person)){	// NEPODARILO SE PRIHLASIT
	invalidLoginPage();
}

else{	//Jsme prihlaseni
 	//Ulozeni prihlaseni. Nastavim SESSION a ulozim aktivni Cookie
 	$_SESSION['user']=$person['login'];
 	setcookie("Active", 1, time()+3600,"/"); 
 	redirect('main.php');

}

?>