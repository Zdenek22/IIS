<?php

// funkce pro vytvoreni stranky pro prodej leku


// nektere funkce jsou v mainpage.php, takto se zkompletuje stranka
// usage:	makeSellPage()
//			mainPageButtons()
//			overview($info)/overviewReserv($info) - podle toho, jestli se tam jde z rezervace nebo pres lek
//			userAccountInfo()
//			endSellPage()


require_once "DBOperations.php";

// zacatek stranky s rezervacemi
function makeSellPage(){
	header("Content-Type: text/html; charset=UTF-8");
	?>
	<!DOCTYPE html>
	<html lang="cz">

	<head>
   	 <link rel="stylesheet" type="text/css" href="mainstyle.css">
   	 <link rel="icon" type="image/x-icon" href="snake.png">
   	 <title>Lékárna - prodej léku</title>
	</head>
	<body>
	<?php
	$server = new Database_access();
	$user = $server->getInformation($_SESSION['user']);
	?>
		<h1>Lékárna - pobočka <? echo $user['pobocka']; ?> - Prodej léku</h1>
		<div style="margin-bottom: 2cm"></div>
	<?php
}

// zobrazi prehled k prodeji leku
function overview($info){
	$jmeno = $info['jmeno'];
	$pocet = $info['pocet'];
	$kus = $info['cenakus'];
	$sleva="";$RC="";$pojistovna="";$predpis=0;
	if($info['predpis'] == '1'){
		$sleva = $info['sleva'];
		$RC = $info['RC'];
		$pojistovna = $info['pojistovna'];
		$predpis = 1;
	}	

	$celkem = 0;
	$bezslevy = $pocet * $kus;
	if($predpis == 1){
		$celkem = ($pocet * $kus) - ($pocet * $sleva);
	}	
	else{
		$celkem = $pocet * $kus;
	}
	?>
	<div class="secondCol">
		<table class="overviewTable">
			<tr>
				<td class="otd">Lék:</td>
				<td class="mtd"><?echo $jmeno;?></td>
			</tr>
			<tr>
				<td class="otd">Množství:</td>
				<td class="mtd"><?echo $pocet;?> Ks</td>
			</tr>
			<tr>
				<td class="otd">Cena za kus:</td>
				<td class="mtd"><?echo $kus;?> Kč</td>
			</tr>
			<?php
			if($predpis == 1){
				?><tr>
					<td class="otd">Rodné číslo:</td>
					<td class="mtd"><?echo $RC;?></td>
				</tr>
				<tr>
					<td class="otd">Pojišťovna:</td>
					<td class="mtd"><?echo $pojistovna;?></td>
				</tr>
				<tr>
					<td class="otd">Sleva od pojišťovny:</td>
					<td class="mtd"><?echo $sleva;?> Kč</td>
				</tr>
				<?php
			}
			?>
				<tr>
					<td class="otd">Cena celkem:</td>
					<td class="mtd"><?echo $celkem;?> Kč</td>
				</tr>	

			<tr>
				<td class="otd">
					<form action="main.php">
						<input class="cancelButtTemp" type="submit" name="cancel" value="Storno" style="background-color: red;color: white;">
					</form>
				</td>
				<td class="mtd">
					<form action="operations.php" method="post">
						<input type="hidden" name="lek" value=<?echo '"';echo $info['jmeno'];echo '"';?>>
						<input type="hidden" name="celkem" value=<?echo '"';echo $bezslevy;echo '"';?>>
						<input type="hidden" name="RC" value=<?echo '"';echo $info['RC'];echo '"';?>>
						<input type="hidden" name="pocet" value=<?echo '"';echo $info['pocet'];echo '"';?>>
						<input type="hidden" name="pojistovna" value=<?echo '"';echo $info['pojistovna'];echo '"';?>>
						<input class="finishBut" type="submit" name="finish" value="Dokončit" style="background-color: #4CAF50;color: white;">
					</form>
				</td>
			</tr>
		</table>	
	</div>
	<?php
}


function overviewReserv($count, $info, $zakaznik, $pobocka, $num){
	// 'lek' - jmeno leku, 'rezervace' -> prispevek na lek, 'neslevnenaCena'->cena za kus, 'pocet' -> mnozstvi leku, 
	// 'celkemBezSlevy' -> pobocka celkem, 'celkemSeSlevou'
	?>
	<div class="secondCol">
		<table class="overviewTable">
		<?php
		for ($i=0; $i < $count; $i++) { 
			?>
			<tr>
				<td class="otd">Lék:</td>
				<td class="mtd"><?echo $info[$i]['lek'];?></td>
			</tr>
			<tr>
				<td class="otd">Množství:</td>
				<td class="mtd"><? echo $info[$i]['pocet']; ?> Ks</td>
			</tr>
			<tr>
				<td class="otd">Cena za kus:</td>
				<td class="mtd"><?echo $info[$i]['neslevnenaCena'];?> Kč</td>
			</tr>
			<tr>
				<td class="otd">Sleva od pojišťovny:</td>
				<td class="mtd"><? echo $info[$i]['rezervace']; ?></td>
			</tr>
			<tr>
				<td class="otd"></td>
				<td class="mtd"></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="otd">Cena celkem bez slevy:</td>
			<td class="mtd"><?echo $pobocka;?> Kč</td>
		</tr>
		<tr>
			<td class="otd">Cena celkem se slevou:</td>
			<td class="mtd"><?echo $zakaznik;?> Kč</td>
		</tr>
		<tr>
			<td class="otd">
				<form action="main.php">
					<input class="cancelButtTemp" type="submit" name="cancel" value="Storno" style="background-color: red;color: white;">
				</form>
			</td>
			<td>
				<form action="operations.php" method="get">
					<input type="hidden" name="penez" value=<?echo '"';echo $pobocka;echo '"';?>>
					<input type="hidden" name="cislo" value=<?echo '"';echo $num;echo '"';?>>
					<input class="finishBut" type="submit" name="finish" value="Dokončit" style="background-color: #4CAF50;color: white;">
				</form>
			</td>
		</tr>
		</table>
	</div>	
	<?php
}


// ukonceni stranky
function endSellPage(){
	?>
			</div> <!-- konec thirdCol -->
		</body>
	</html>
	<?php
}
?>


