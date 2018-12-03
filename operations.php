<?php
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";
require_once "sellpage.php";
require_once "mainpage.php";
require_once "accountinfo.php";
require_once "employeelistpage.php";


$server = new Database_access();
header("Content-Type: text/html; charset=UTF-8");
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

		$ZAKAZNIK_CELKEM=0;
		$POBOCKA_CELKEM=0;
		//spocitat celkovou cenu pro zakaznika
		//spocitat celkovou castku pro lekarnu
		foreach ($rezervuje as $key => $value) {
			$rezervuje[$key]['neslevnenaCena'] = $server->getMedsValue($value['lek']);
			$rezervuje[$key]['celkemBezSlevy'] = ($rezervuje[$key]['neslevnenaCena'])*($rezervuje[$key]['pocet']);
			$rezervuje[$key]['celkemSeSlevou'] = $rezervuje[$key]['celkemBezSlevy']-($rezervuje[$key]['pocet']*$rezervuje[$key]['rezervace']);
			$rezervuje[$key]['lek'] = $server->getMedsName($value['lek']);
			$ZAKAZNIK_CELKEM+=$rezervuje[$key]['celkemSeSlevou'];
			$POBOCKA_CELKEM+=$rezervuje[$key]['celkemBezSlevy'];
		}
		
		//nahradit cisla leku jmenem getMedsName
		foreach ($rezervuje as $key => $value) {
		$tmp = $rezervuje[$key]['lek'];
		//echo "celkem se slevou $tmp <br>";
		}
		
		makeSellPage();
		mainPageButtons();
		overviewReserv(count($rezervuje),$rezervuje,$ZAKAZNIK_CELKEM,$POBOCKA_CELKEM, $_GET['id']); //$cout,$rezervace -> [], $zakaznik
		userAccountInfo();
		endSellPage();
}

if(isset($_POST['vydat'])){
	$_POST['lek'] = $server->getMedsName($_POST['lek']); //ZMENA
	//JE TO NA PREDPIS
	$prispevek = 0;
	if($_POST['predpis'] === '1'){
		echo "na predpis"; 

		$anyError=0;

		if (preg_match('#[0-9]#',$_POST['jmeno'])){
			$_POST['jmeno']=0;
			$anyError = 1;
		}

		if (preg_match('#[0-9]#',$_POST['prijmeni'])){
			$_POST['prijmeni']=0;
			$anyError = 1;
		}

		if(!(checkRC($_POST['RC']))){
			$_POST['RC']=0;
			$anyError = 1;
		}

		$pojistovna = $server->getPojistovna($_POST['pojistovna']);

		if(empty($pojistovna)){
			$_POST['pojistovna']=0;
			$anyError = 1;
		}


		if($anyError === 1){
				//echo "chyba";  //TODO KAM PRESMERUJE
			$_POST['lek'] = $server->getMedsID($_POST['lek']);
			?>
			<form id="myForm" action="sellamount.php" method="post">  
			<?php
			    foreach ($_POST as $a => $b) {
			        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
			    }
			?>
			</form>
			<script type="text/javascript">
			    document.getElementById('myForm').submit();
			</script>
			<?
			die();
		}

		$zakaznik = $server->getZakaznik($_POST['RC']);

		if(!(empty($zakaznik))){ //TODO KAM PRESMERUJE
			if($zakaznik['jmeno']!=$_POST['jmeno'] or $zakaznik['prijmeni']!=$_POST['prijmeni']){
				$_POST['lek'] = $server->getMedsID($_POST['lek']);
				$_POST['RC']=1;
				?>
				<form id="myForm" action="sellamount.php" method="post">
				<?php
		   			foreach ($_POST as $a => $b) {
		     		   echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
		  		  	}
				?>
				</form>
				<script type="text/javascript">
		  		  document.getElementById('myForm').submit();
				</script>
				<?
				die();
			}
		}
		else{
				 $server->insertZakaznik($_POST['RC'], $_POST['jmeno'], $_POST['prijmeni']);
			}

		$idPojistovny = $server->getPojistovna($_POST['pojistovna']);
		$idPojistovny = $idPojistovny['id'];
		$idLeku = $server->getMedsID($_POST['lek']);
		$prispevek =$server->getPrispevek($idPojistovny, $idLeku);
	}

	//Kontrola, zda je na sklade dost leku
	$pocet;
	$skladem = $server->getMedicament($_POST['lek'],$_SESSION['pobocka']);
	if(!isset($skladem[0]['pocet']))
		$pocet=0;
	else{
		$pocet= $skladem[0]['pocet'];
	}

	if($_POST['amount']>$pocet){
			$_POST['lek'] = $server->getMedsID($_POST['lek']);
			$_POST['amount']=0;
			?>
			<form id="myForm" action="sellamount.php" method="post">
			<?php
		   		foreach ($_POST as $a => $b) {
		     		echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
		  		}
			?>
			</form>
			<script type="text/javascript">
		  	 document.getElementById('myForm').submit();
			</script>
			<?
			die();
	}

		$_POST['vydat']=$prispevek;
		$_POST['lek'] = $server->getMedsID($_POST['lek']); //ZMENA
		?>
		<form id="myForm" action="sell.php" method="post">
		<?php
		  foreach ($_POST as $a => $b) {
		     	echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
		  	}
		?>
		</form>
		<script type="text/javascript">
		document.getElementById('myForm').submit();
		</script>
		<?
		die();
}


if(isset($_POST['finish'])){

	$server->addMoney($_SESSION['pobocka'], $_POST['celkem']);
	$idLek = $server->getMedsID($_POST['lek']);
	$server->rmvMed($_SESSION['pobocka'], $idLek ,$_POST['pocet']);

	if(isset($_POST['RC'])){
		$idPojistovny= $server->getPojistovna($_POST['pojistovna']);
		$idPojistovny = $idPojistovny['id'];
		$server->addTransaction($_SESSION['user'],$idLek, $_POST['RC'], $idPojistovny, $_POST['pocet']);
	}

	redirect('main.php');

}

if(isset($_GET['finish'])){
	echo "Processing...";
	$server->addMoney($_SESSION['pobocka'], $_GET['penez']);
	$rezervace = $server->getReservation($_GET['cislo']);
	$leky = $server->getReservationMeds($rezervace['id']);

	foreach ($leky as $key => $value) {
		$server->rmvMed($_SESSION['pobocka'], $value['lek'] ,$value['pocet']);
		$idPojistovny= $server->getPojistovna($rezervace['pojistovna']);
		$idPojistovny = $idPojistovny['id'];
		$server->addTransaction($_SESSION['user'],$value['lek'], $rezervace['RC'], $idPojistovny, $value['pocet']);
		sleep(1);
	}
	$server->eraseReservation($rezervace['id'], $_SESSION['user']);
	redirect('main.php');
}

if(isset($_POST['addEmp'])){

			$anyError=0;

		if (preg_match('#[0-9]#',$_POST['jmeno'])){
			$_POST['jmeno']=0;
			$anyError = 1;
		}

		if (preg_match('#[0-9]#',$_POST['prijmeni'])){
			$_POST['prijmeni']=0;
			$anyError = 1;
		}
		echo "$_POST[login]";
		$avalibility = $server->getInformation($_POST['login']);

		if(!empty($avalibility[0])){
			$_POST['login']=0;
			$anyError = 1;
		}
		echo "$_POST[jmeno], $_POST[prijmeni], ";
		if($anyError === 1){
			?>
			<form id="myForm" action="addEmployee.php" method="post">  
			<?php
			    foreach ($_POST as $a => $b) {
			        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
			    }
			?>
			</form>
			<script type="text/javascript">
			    document.getElementById('myForm').submit();
			</script>
			<?
			die();
		}

		//pridat zamestnance
		$idPobocky = $server->getPobockaID($_POST['pobocka']);
		$postaveni = $_POST['postaveni'];

		echo "$_POST[telefon]  $_POST[email]";

		if(!empty($_POST['telefon']))
			$telefon = $_POST['telefon'];

		if(!empty($_POST['email']))
			$email = $_POST['email'];		

		$server->addWorker($_POST['login'], $_POST['heslo'], $_POST['jmeno'], $_POST['prijmeni'], $telefon, $email, $idPobocky, $_POST['postaveni']);
		redirect('main.php');
}

if(isset($_POST['addMed'])){
		//pridat zamestnance
		$try = $server->getMedsID($_POST['jmeno']);
		$anyError=0;
		if(!empty($try)){
			$anyError = 1;
			$_POST['jmeno']=0;
		}

		if($anyError === 1){
			?>
			<form id="myForm" action="addMed.php" method="post">  
			<?php
			    foreach ($_POST as $a => $b) {
			        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
			    }
			?>
			</form>
			<script type="text/javascript">
			    document.getElementById('myForm').submit();
			</script>
			<?
			die();
		}

		$server->addMed($_POST['jmeno'], $_POST['cena'], $_POST['predpis'], $_POST['popis']);

		$idLeku= $server->getMedsID($_POST['jmeno']);

		$pobocky = $server->getAllPobockaID();
		$nula = 0;
		foreach ($pobocky as $key => $value) {
			$server->addNewMed($idLeku, $value['id'],$nula);
		}
		$server->addMeds($idLeku, $_SESSION['pobocka'], $_POST['amount']);
		redirect('main.php');
}

if(isset($_POST['addPobocka'])){
		
		$server->addPobocka($_POST['jmeno'],$_POST['mesto'], $_POST['ulice'], $_POST['cislo'], $_POST['psc'],  $_POST['penize']);

		$idPobocky= $server->getPobockaID($_POST['jmeno']);
		//echo "$idPobockyleky
		$leky = $server->getAllLekID();
		$nula = 0;
		foreach ($leky as $key => $value) {
			$server->addNewMed($value['id'], $idPobocky, $nula);
		}
		redirect('main.php');
}

if(isset($_GET['zamestnanci'])){
	makeEmployeeListPage();
	mainPageButtons();
	startEmployeeListTable();
	$zamestnanci = $server->getAllZamestnanec();
	foreach ($zamestnanci as $key => $value) {
		fillEmployeeListTable($value);
	}
	
	endEmployeeListTable();
	userAccountInfo();
	endEmployeeListPage();

}
?>