<?php

function invalidLoginPage(){
  header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="cz">

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="icon" type="image/x-icon" href="snake.png">
  <title>Lékárna - Chyba přihlášení</title>
</head>

<body>
	<h1>Lékárna</h1>
	<div class="imgcontainer">
    	<img src="snake.png" class="logo">
  </div>
  <div class="error">
		Nesprávné jméno nebo heslo!<br>
		<form class="errorForm" action="index.html">
			<button class="errorButton">Zpět na přihlášení</button>			
		</form>
  </div>
</body>
</html>

<?php
  }
?>