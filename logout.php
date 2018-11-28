<?php
session_save_path("./tmp");
session_start();

unset($_SESSION['user']);
setcookie("Active",1,time()-1,"/");
?>
Byli jste odhláseni. Kliknutím <a href="index.html">sem</a> se vrátíte na pùvodní stránku.