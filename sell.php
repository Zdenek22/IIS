<?
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";
require_once "sellpage.php";
require_once "mainpage.php";
require_once "accountinfo.php";
checkNsetLogin();
$server = new Database_access();
$_POST['lek'] = $server->getMedsName($_POST['lek']); //ZMENA
$idLeku = $server->getMedsID($_POST['lek']);
$cenaLeku = $server->getMedsValue($idLeku);

$params['jmeno'] = $_POST['lek'];
$params['pocet'] = $_POST['amount'];
$params['cenakus'] = $cenaLeku;
$params['sleva'] = $_POST['vydat'];
if(isset($_POST['RC']))
	$params['RC'] = $_POST['RC'];
if(isset($_POST['pojistovna']))
	$params['pojistovna'] = $_POST['pojistovna'];
$params['predpis'] = $_POST['predpis'];



makeSellPage();
mainPageButtons();
overview($params);
userAccountInfo();
endSellPage();


?>