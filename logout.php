<?php
session_save_path("./tmp");
session_start();

unset($_SESSION['user']);
setcookie("Active",1,time()-1,"/");
?>
Byli jste odhl�seni. Kliknut�m <a href="index.html">sem</a> se vr�t�te na p�vodn� str�nku.