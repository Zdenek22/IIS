<?php
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";

echo "$_POST[lek]<br> $_POST[prijmeni]<br> $_POST[RC]<br> $_POST[pojistovna]<br> $_POST[amount]<br>";

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

$server = new Database_access();
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
	else{
		echo "jmena sedi";
	}
}
else{
	echo "nic nemame!<br>";
}


//later spass
/*
<form id="myForm" action="Page_C.php" method="post">
<?php
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>*/
?>
