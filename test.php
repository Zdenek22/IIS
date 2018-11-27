<?php
session_start();
if(isset($_COOKIE['Active'])){
	echo "susa je: $_COOKIE[Active] <br>";	
}
else{
	echo "susa neni :(.<br>";
}
if(isset($_SESSION['user'])){
	echo "Session je je: $_SESSION[user] <br>";	
}
else{
	echo "Session neni neni :(.<br>";
}

?>