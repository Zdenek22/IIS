<?
session_save_path("./tmp");
session_start();

require_once "DBOperations.php";
require_once "supFunct.php";
require_once "sellpage.php";
require_once "mainpage.php";
require_once "accountinfo.php";
require_once "evidencepage.php";


$server = new Database_access();

makeEvidencePage();
mainPageButtons();
startEvidenceTable();


$transakce= $server->getTransactions();
if (!empty($transakce)) {
	foreach ($transakce as $key => $value) {
		fillEvidenceTable($value);
	}
}

endEvidenceTable();
userAccountInfo();
endSellAmountPage();