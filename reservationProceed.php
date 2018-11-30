<?php
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";

$server = new Database_access();

if(!(isset($_COOKIE['tmp_rezervace']))){
	echo "susa neni nastavena<br>";
	$zalohaPOST=$_POST;
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
		?>
	<form id="myForm" action="createreserv.php" method="post">
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
	}

	$zakaznik = $server->getZakaznik($_POST['RC']);

	if(!(empty($zakaznik))){
		if($zakaznik['jmeno']!=$_POST['jmeno'] or $zakaznik['prijmeni']!=$_POST['prijmeni']){
			$_POST['RC']=1;
			?>
			<form id="myForm" action="createreserv.php" method="post">
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
		}
	}
	else{	//pridame TMP zakaznika do nasi databaze
		$server -> insertZakaznik($_POST['RC'],$_POST['jmeno'],$_POST['prijmeni']);
		setcookie("tmp_zakaznik", $_POST['RC'], time()+3600*24*7*365*5,"/"); 
	}
	//vytvorime docasnou rezervaci
	$idRezervace = $server->insertReservation($_SESSION['user'], $pojistovna['id'], $_POST['RC'], $_SESSION['pobocka']);  //TODO zmenit pobocku podle zadane pobocky
	setcookie("tmp_rezervace", $idRezervace, time()+3600*24*7*365*5,"/"); 

	//TODO do rezervuje pridat lek a mnozstvi
}

	//TODO do rezervuje pridat lek a mnozstvi

	//TODO vytvorit funkci, ktera pri logoutu, nebo i na jinych mistech odebere tmp_cookie a zaznamy na ktere odkazuji z DB
?>
