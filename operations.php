<?php
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";

$server = new Database_access();

if(isset($_GET['add'])){
	$server->addMeds()

}

redirect('store.php');
?>