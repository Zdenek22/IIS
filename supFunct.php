<?php
function redirect($dest){
    $script = $_SERVER["PHP_SELF"];
    if (strpos($dest,'/')) {
        $path = $dest;
    } else {
        $path = substr($script, 0, strrpos($script, '/')) . "/$dest";
    }
    $name = $_SERVER["SERVER_NAME"];
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://$name$path");
}


function checkNsetLogin(){
    //zkontroluje, zda jsou nastaveny Cookies, a SESSION
    if(isset($_SESSION['user']) and isset($_COOKIE['Active'])){
        //prodlouzim dobu trvani Cookies
	setcookie("Active", 1, time()+3600,"/"); 
    }
    else{
	setcookie("Active", 1, time()-3,"/");
	unset($_SESSION['user']);
	redirect('index.html');
    } 
}
?>