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

function vypisRezervace($idPobocky,$idRezervace){
    $server = new Database_access();

    if($idPobocky==='')
        $reservations = $server->getReservations($_SESSION['pobocka'],$idRezervace);
    else
        $reservations = $server->getReservations($idPobocky,$idRezervace);
    

foreach ($reservations as $key => $value) {
    $leky = $server->getMedsInReservation($value['id']);
    $pocet = count($leky);
    $counter = 0;
    foreach ($leky as $keyy => $valuee) {
        $cena = $server->getMedsValue($valuee['lek']);
        $leky[$counter]['rezervace'] = $cena;
        $leky[$counter]['lek'] = $server->getMedsName($valuee['lek']);
        $counter = $counter+1;
    }
    //foreach ($leky as $key => $value) {
     //   echo "$key je $value <br>";
     //   foreach ($value as $keyy => $valuee) {
     //       echo "$keyy je $valuee <br>";}
    //}

    fillReservTable($pocet, $value, $leky);
}
}
?>