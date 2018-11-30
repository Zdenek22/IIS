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

function checkRC($RC){
    $certovina = 0;

    if(is_numeric($RC)){
        $certovina +=1;
    }

    if(($RC>100000000) and ($RC<9999999999) and ($RC%11 === 0)){
    $certovina +=1;
    }
    //and
    if(( (($RC%100000000 - $RC%1000000)/1000000) < 13)or(( (($RC%100000000 - $RC%1000000)/1000000) > 50) and ( (($RC%100000000 - $RC%1000000)/1000000) < 63))){
       $certovina +=1;
    } 


    if(( ((($RC%1000000) - ($RC%10000))/10000) > 0 )AND ( ((($RC%1000000) - ($RC%10000))/10000) < 31)) {
        $certovina +=1;
    }

    if ($certovina === 4)
       return true;
   return false;
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

//Odstrani cookies tmp, a spolu s nimi zaznamy v tabulkach ktere se jich tykaji
function deleteTmp(){
    $server = new Database_access();
    if(isset($_COOKIE['tmp_rezervace'])){
         $server->deleteReserves($_COOKIE['tmp_rezervace']);
         $server->deleteReservation($_COOKIE['tmp_rezervace']);
         setcookie('tmp_rezervace', 0, time()-3,"/");
    }

    if(isset($_COOKIE['tmp_zakaznik'])){
         $server->deleteCustomer($_COOKIE['tmp_zakaznik']);
         setcookie('tmp_zakaznik', 0, time()-3,"/");
    }

}
?>