<?php
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";

$server = new Database_access();

if(isset($_GET['add'])){
	$id = $server->getMedsID($_GET['lek']);
	$tmp= $server->addMeds($id, $_SESSION['pobocka'], $_GET['add']);
	redirect('store.php');
}

if(isset($_GET['sub'])){
	echo "$_GET[pocet], $_GET[sub]";
	if($_GET['sub']>$_GET['pocet']){
		?>
		<form id="myForm" action="store.php" method="get">
		<?php
	 	    echo '<input type="hidden" name="'.'sub'.'" value="'.'0'.'">';
		?>
		</form>
		<script type="text/javascript">
	    document.getElementById('myForm').submit();
		</script>
		<?
	}
	else{
	$id = $server->getMedsID($_GET['lek']);
	$tmp= $server->addMeds($id, $_SESSION['pobocka'], $_GET['sub']*(-1));
	redirect('store.php');
	}
}

if(isset($_GET['saveReserv'])){
    if(isset($_COOKIE['tmp_rezervace']))
         setcookie('tmp_rezervace', 0, time()-3,"/");

    if(isset($_COOKIE['tmp_zakaznik']))
         setcookie('tmp_zakaznik', 0, time()-3,"/");
     redirect('main.php');
}


if(isset($_GET['cancelReserv'])){
	deleteTmp();
	redirect('main.php');
}

if(isset($_GET['reservation']) and $_GET['reservation'] === 'Storno'){
	$server->eraseReservation($_GET['id'], $_SESSION['user']);
	redirect('reservations.php');
}

if(isset($_GET['reservation']) and $_GET['reservation'] === 'Vydej'){
	$rezervuje = $server->getReservationMeds($_GET['id']);
	$nedostatek = 0;

		foreach ($rezervuje as $key => $value) {
			$val=$server->getSkladem($_SESSION['pobocka'], $value['lek']);
			$rezervuje[$key]['rezervace'] = 0;
			if(!isset($val) or $val < $value['pocet']){
				$nedostatek = 1;
			}
		}

	if($nedostatek === 1){
		?>
		<form id="myForm" action="reservations.php" method="get">
		<?php
		        echo '<input type="hidden" name="'."rezervation".'" value="'."0".'">';
		?>
		</form>
		<script type="text/javascript">
		    document.getElementById('myForm').submit();
		</script>
		<?
		die();
	}

	//nahradit cisla leku jmenem
	$rezervace = $server->getPlainReservation($_GET['id']); //pojistovna je [2]
		//TODO, projit a hledat prispevky
		foreach ($rezervuje as $key => $value) {
			$val=$server->getPrispevek($rezervace[2], $value['lek']);
			$rezervuje[$key]['rezervace'] = $val;
		}

		//spocitat celkovou cenu pro zakaznika
		//spocitat celkovou castku pro lekarnu
		foreach ($rezervuje as $key => $value) {
			$val=$server->getMedsValue($value['lek']);
			$rezervuje[$key]['neslevnenaCena'] = $val;
		}

		foreach ($rezervuje as $key => $value) {
			echo "neslevnena cena $value[neslevnenaCena]<br>";}

		foreach ($rezervuje as $key => $value) {
			$rezervuje[$key]['celkemBezSlevy'] = ($rezervuje[$key]['neslevnenaCena'])*($rezervuje[$key]['pocet']);
			$tmp = $rezervuje[$key]['celkemBezSlevy'];
			echo "celkem $tmp <br>";}

		foreach ($rezervuje as $key => $value) {
			$rezervuje[$key]['celkemSeSlevou'] = $rezervuje[$key]['celkemBezSlevy']-($rezervuje[$key]['pocet']*$rezervuje[$key]['rezervace']);
			$tmp = $rezervuje[$key]['celkemSeSlevou'];
			echo "celkem se slevou $tmp <br>";}

			//nahradit cisla leku jmenem getMedsName
			foreach ($rezervuje as $key => $value) {
			$rezervuje[$key]['lek'] = $server->getMedsName($value['lek']);
			$tmp = $rezervuje[$key]['lek'];
			echo "celkem se slevou $tmp <br>";}

}
?>