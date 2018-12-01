<?php
session_save_path("./tmp");
session_start();

require_once "mainpage.php";
require "supFunct.php";
require "reservpage.php";
require_once "DBOperations.php";
require_once "detailreservpage.php";
require_once "accountinfo.php";


checkNsetLogin();

makeDetailReservPage();
mainPageButtons();


    $server = new Database_access();
    

    $leky = $server->getMedsInReservation($_COOKIE["tmp_rezervace"]);
    $pocet = count($leky);
    $counter = 0;
    foreach ($leky as $keyy => $valuee) {
        $cena = $server->getMedsValue($valuee['lek']);
        $leky[$counter]['rezervace'] = $cena;
        $leky[$counter]['lek'] = $server->getMedsName($valuee['lek']);
        $counter = $counter+1;
    }

    fillReservTable($pocet, $_COOKIE["tmp_rezervace"], $leky);



endTable();
reservFindBar();
userAccountInfo();
endReservDetailPage();
?>

