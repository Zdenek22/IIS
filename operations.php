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

?>