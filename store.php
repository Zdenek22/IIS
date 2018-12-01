<?php
session_save_path("./tmp");
session_start();

require_once "supFunct.php";
require_once "mainpage.php";
require_once "storepage.php";
require_once "DBOperations.php";
require_once "accountinfo.php";

makeStorePage();
mainPageButtons();
startStoreTable();

$jmeno='';
$server = new Database_access();
$medicaments = $server->getMedicament($jmeno, $_SESSION['pobocka']);

foreach($medicaments as $key => $value){
	fillStoreTable($value);
}

endStoreTable();
userAccountInfo();
endStorePage();

?>
