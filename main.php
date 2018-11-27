<?php
session_save_path("./tmp");
session_start();

require "supFunct.php";
require "mainpage.php";

checkNsetLogin();

makeMainPage();
mainPageButtons();
startTable();
fillTable('xrita', false);
endTable();
mainFindBar();
userInfo('xrita');
endMainPage();
?>
