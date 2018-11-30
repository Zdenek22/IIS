<?php
session_save_path("./tmp");
session_start();
require "DBOperations.php";
require "supFunct.php";
deleteTmp();
unset($_SESSION['user']);
unset($_SESSION['pobocka']);
setcookie("Active",1,time()-1,"/");
redirect("index.html");
?>
