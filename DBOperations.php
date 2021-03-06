<?php

class Database_access
{
    private $pdo;
    private $lastError;
    
    function __construct()
    {
        $this->pdo = $this->connect_db();
        $this->lastError = NULL;
    }

    public function __destruct()
    {
        $this->pdo = NULL;
    }

    function connect_db()
    {
        $dsn = "mysql:host=localhost;dbname=xgrego18;port=/var/run/mysql/mysql.sock";
        $username = 'xgrego18';
        $password = '3ajtejne';
        $pdo = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND =>  'SET NAMES utf8'));
        return $pdo;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL)
            return '';
        else
            return $this->lastError[2]; //the message
    }
    

    //Funkce vraci seznam leku a jejich mnozstvi nachazejicich se na ID POBOCKY. Pokud jmeno leku neni specifikovano, vrati vsechny
    function getMedicament($jmeno,$idPobocky)
    {
        if($jmeno === ''){
            $stmt = $this->pdo->prepare('SELECT lek.jmeno, lek.cena, lek.predpis, lek.popis, skladem.pocet FROM lek, skladem WHERE skladem.pobocka= ? AND lek.id = skladem.lek');
            $stmt->execute(array($idPobocky));
            return $stmt->fetchAll();
        }
        else{
            $stmt = $this->pdo->prepare('SELECT lek.jmeno, lek.cena, lek.predpis, lek.popis, skladem.pocet  FROM lek, skladem WHERE skladem.pobocka= ? AND lek.id = skladem.lek AND lek.jmeno LIKE ?');
            $stmt->execute(array($idPobocky, $jmeno.'%'));
            return $stmt->fetchAll();
        }
    }



    //Funkce vraci ID a JMENO pojistovny, zadane jmenem
    function getPojistovna($jmeno)
    {
            $stmt = $this->pdo->prepare('SELECT id, jmeno  FROM pojistovna WHERE jmeno= ? ');
            $stmt->execute(array($jmeno));
            return $stmt->fetch();
    }

    //Funkce vraci JMENO a PRIJMENI zakaznika, zadane RC
    function getZakaznik($RC)
    {
            $stmt = $this->pdo->prepare('SELECT jmeno, prijmeni FROM zakaznik WHERE RC= ? ');
            $stmt->execute(array($RC));
            return $stmt->fetch();
    }

    function insertMeds($idLeku, $idRezervace, $mnozstvi){
        $stmt = $this->pdo->prepare('SELECT pocet FROM rezervuje WHERE lek = ? AND rezervace = ?');
        $stmt->execute(array($idLeku, $idRezervace));
        $res = $stmt->fetch();
        if(empty($res)){
            echo "tadyy";
            $stmt = $this->pdo->prepare("INSERT INTO rezervuje (lek, rezervace, pocet) VALUES(?, ?,?)");
            $stmt->execute(array($idLeku, $idRezervace, $mnozstvi));
        }
        else{
            $var =$mnozstvi+$res['pocet'];
            $stmt = $this->pdo->prepare("UPDATE rezervuje SET pocet = ? WHERE lek = ? AND rezervace=?");
            $stmt->execute(array($var, $idLeku, $idRezervace));
        }
    }

    function changeEmail($email, $login){
            $stmt = $this->pdo->prepare("UPDATE uzivatel SET email = ? WHERE login = ?");
            $stmt->execute(array($email, $login));
    }

    function changeTelefon($telefon, $login){
            $stmt = $this->pdo->prepare("UPDATE uzivatel SET telefon = ? WHERE login = ?");
            $stmt->execute(array($telefon, $login));
    }
    function changeHeslo($heslo, $login){
            $stmt = $this->pdo->prepare("UPDATE uzivatel SET heslo = ? WHERE login = ?");
            $stmt->execute(array($heslo, $login));
    }

    //Funkce ulozi zakaznika, zadane RC, jmeno, prijmeni
    function insertZakaznik($RC, $jmeno, $prijmeni)
    {
            $stmt = $this->pdo->prepare("INSERT INTO zakaznik (RC, jmeno, prijmeni) VALUES(?, ?,?)");
            $stmt->execute(array($RC, $jmeno, $prijmeni));
    }

    function insertReservation($login, $pojistovna, $RC, $pobocka)
    {
           // echo "$login, $pojistovna, $RC, $pobocka";
            $stmt = $this->pdo->prepare("INSERT INTO rezervace (vytvoril, pojistovna, RC, pobocka, ukoncenaVydanim) VALUES(?,?,?,?,0)");
            $stmt->execute(array($login, $pojistovna, $RC, $pobocka));

            $stmt = $this->pdo->prepare('SELECT id FROM rezervace WHERE vytvoril = ? AND pojistovna = ? AND RC = ?');
            $stmt->execute(array($login, $pojistovna, $RC));
            $results = $stmt->fetchAll();
            $integer;
            foreach ($results as $key => $value) {
                $integer = $value['id'];
            }
            return $integer;
    }

    //vraci seznam OTEVRENYCH rezervaci na zadane pobocce
    function getReservations($idPobocky, $idRezervace)
    { 
        if($idRezervace ===''){
            $stmt = $this->pdo->prepare('SELECT rezervace.id, rezervace.vytvoril, pojistovna.jmeno pojistovna, rezervace.RC, pobocka.jmeno  FROM rezervace, pobocka, pojistovna WHERE rezervace.pobocka= ? AND rezervace.pobocka = pobocka.id AND pojistovna.id = rezervace.pojistovna AND rezervace.ukoncil is null LIMIT 100');
            $stmt->execute(array($idPobocky));
        }
        else{
            $stmt = $this->pdo->prepare('SELECT rezervace.id, rezervace.vytvoril, pojistovna.jmeno pojistovna, rezervace.RC, pobocka.jmeno  FROM rezervace, pobocka, pojistovna WHERE rezervace.pobocka= ? AND rezervace.pobocka = pobocka.id AND pojistovna.id = rezervace.pojistovna AND rezervace.id = ?');
            $stmt->execute(array($idPobocky, $idRezervace));
        }
            return $stmt->fetchAll();
    }


    //kolik je pocet o kolik se ma pocet leku zvysit
    function addMeds($lek, $kde, $kolik){
        $stmt = $this->pdo->prepare('SELECT pocet FROM skladem WHERE  pobocka =? AND lek = ?');
        $stmt->execute(array($kde, $lek));
        $result = $stmt->fetch();
        $result = $result['pocet'];
        $result+= $kolik;

        $stmt =$this->pdo->prepare('UPDATE skladem SET pocet = ? WHERE pobocka = ? AND lek =?');
        $stmt->execute(array($result, $kde, $lek));
    }

    function addNewMed($lek, $kde,$nula){
        $stmt = $this->pdo->prepare('INSERT INTO skladem (pobocka, lek, pocet) VALUES(?,?,?)');
        $stmt->execute(array($kde, $lek, $nula));
      
    }


    function eraseReservation($idRezervace, $kdo){
        $stmt =$this->pdo->prepare('UPDATE rezervace SET ukoncil=?, ukoncenaVydanim = 0 WHERE id =?');
        $stmt->execute(array($kdo, $idRezervace));
    }

    function completeReservation($idRezervace, $kdo){
        $stmt =$this->pdo->prepare('UPDATE rezervace SET ukoncil=?, ukoncenaVydanim = 1 WHERE id =?');
        $stmt->execute(array($kdo, $idRezervace));
    }

    function getReservation($idRezervace)
    { 
        $stmt = $this->pdo->prepare('SELECT rezervace.id, rezervace.vytvoril, pojistovna.jmeno pojistovna, rezervace.RC, pobocka.jmeno  FROM rezervace, pobocka, pojistovna WHERE  rezervace.pobocka = pobocka.id AND pojistovna.id = rezervace.pojistovna AND rezervace.id = ?');
        $stmt->execute(array($idRezervace));
        return $stmt->fetch();
    }

    function getPlainReservation($idRezervace)
    { 
        $stmt = $this->pdo->prepare('SELECT id, vytvoril, pojistovna, RC, pobocka  FROM rezervace WHERE id = ?');
        $stmt->execute(array($idRezervace));
        return $stmt->fetch();
    }

    function getPrispevek($idPojistovny, $idleku){
        $stmt = $this->pdo->prepare('SELECT kolik  FROM prispiva WHERE pojistovna = ? AND lek =?');
        $stmt->execute(array($idPojistovny, $idleku));
        $tmp = $stmt->fetch();
        $tmp = $tmp[0];
        if(!(isset($tmp)))
            $tmp = 0;
        return $tmp;
    }

    function getReservationMeds($idRezervace){
        $stmt = $this->pdo->prepare('SELECT rezervace, lek, pocet FROM rezervuje WHERE rezervace = ?');
        $stmt->execute(array($idRezervace));
        return $stmt->fetchAll();
    }

    function getSkladem($idprodejny, $idLeku){
        $stmt = $this->pdo->prepare('SELECT pocet FROM skladem WHERE pobocka = ? AND lek=?');
        $stmt->execute(array($idprodejny,$idLeku));
        $res = $stmt->fetch();
        return $res[0];
    }

    //pouzivano
    function getPerson($id)
    {
        $stmt = $this->pdo->prepare('SELECT login, heslo, jmeno, prijmeni, pobocka, email, telefon, postaveni FROM uzivatel WHERE login = ? AND heslo = ?');
        $stmt->execute(array($id[0],$id[1]));
        return $stmt->fetch();
    }
    
    //na zaklade ID vypise JMENO POBOCKY
    function getPobockaName($id)
    {
        $stmt = $this->pdo->prepare('SELECT jmeno FROM pobocka WHERE id = ?');
        $stmt->execute(array($id));
        $result = $stmt->fetch();
        return $result['jmeno'];
    }

    function getPobockaID($name)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM pobocka WHERE jmeno = ?');
        $stmt->execute(array($name));
        $result = $stmt->fetch();
        return $result['id'];
    }

    function getMedsInReservation($idRezervace){
        $stmt = $this->pdo->prepare('SELECT rezervace, lek, pocet FROM rezervuje WHERE rezervace = ? LIMIT 100');
            $stmt->execute(array($idRezervace));
            return $stmt->fetchAll();
    }

    function getMedsValue($idLeku){
        $stmt = $this->pdo->prepare('SELECT cena FROM lek WHERE id = ? LIMIT 100');
        $stmt->execute(array($idLeku));
        $result = $stmt->fetch();
        return $result['cena'];
    }

    function getMedsName($idLeku){
        $stmt = $this->pdo->prepare('SELECT jmeno FROM lek WHERE id = ? LIMIT 100');
        $stmt->execute(array($idLeku));
        $result = $stmt->fetch();
        return $result['jmeno'];
    }

    function getMedsID($jmenoLeku){
        $stmt = $this->pdo->prepare('SELECT id FROM lek WHERE jmeno = ? LIMIT 100');
        $stmt->execute(array($jmenoLeku));
        $result = $stmt->fetch();
        return $result['id'];
    }

    function getAllPobockaID(){
        $stmt = $this->pdo->prepare('SELECT id FROM pobocka LIMIT 100');
        $stmt->execute(array());
        return $stmt->fetchAll();
    }

     function getAllLekID(){
        $stmt = $this->pdo->prepare('SELECT id FROM lek LIMIT 100');
        $stmt->execute(array());
        return $stmt->fetchAll();
    }



    function addTransaction($kdo, $co, $komu, $pojistovna, $kolik){
        //echo "$kdo, $co, $komu, $pojistovna, $kolik";
        $stmt = $this->pdo->prepare("INSERT INTO prodal (kdy, kdo, co, komu, pojistovna, kolik) VALUES(now(),?,?,?,?,?)");
        $stmt->execute(array($kdo, $co, $komu, $pojistovna, $kolik));
    }

    function addWorker($login, $heslo, $jmeno, $prijmeni, $telefon, $email, $pobocka, $postaveni){
        $stmt = $this->pdo->prepare("INSERT INTO uzivatel (login, heslo, jmeno, prijmeni, telefon, email, pobocka, postaveni) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->execute(array($login, $heslo, $jmeno, $prijmeni, $telefon, $email, $pobocka, $postaveni));
    }

    function addMed($jmeno, $cena, $predpis, $popis){
        $stmt = $this->pdo->prepare("INSERT INTO lek (jmeno, cena, predpis, popis) VALUES(?,?,?,?)");
        $stmt->execute(array($jmeno, $cena, $predpis, $popis));
    }

    //na zaklade LOGIN vypise OSOBNI UDAJE
    function getInformation($id)
    {
        $stmt = $this->pdo->prepare('SELECT jmeno, prijmeni, pobocka, email, telefon, postaveni FROM uzivatel WHERE login = ?');
        $stmt->execute(array($id));
        $result = $stmt->fetch();
        if(isset($result)){
            $result['pobocka'] = $this->getPobockaName($result['pobocka']);
            $result[2] = $result['pobocka'];
        }
        return $result;
    }

    function deleteReserves($idRezervace){
        $stmt = $this->pdo->prepare('DELETE FROM rezervuje WHERE rezervace = ?');
        $stmt->execute(array($idRezervace));
    }

    function deleteReservation($idRezervace){
        $stmt = $this->pdo->prepare('DELETE FROM rezervace WHERE id = ?');
        $stmt->execute(array($idRezervace));
    }

    function deleteCustomer($RC){
        $stmt = $this->pdo->prepare('DELETE FROM zakaznik WHERE RC = ?');
        $stmt->execute(array($RC));
    }

    function addMoney($kam, $kolik){
        $stmt = $this->pdo->prepare('SELECT Penize FROM pobocka WHERE id = ?');
        $stmt->execute(array($kam));
        $result = $stmt->fetch();
        $result = $result['Penize'];
        $result += $kolik;
        $stmt = $this->pdo->prepare('UPDATE pobocka SET Penize = ? WHERE id = ?');
        $stmt->execute(array($result,$kam));
    }

    function getAllPobocka(){
        $stmt = $this->pdo->prepare('SELECT jmeno FROM pobocka');
        $stmt->execute(array());
        return $stmt->fetchAll();
    }

    function getAllPojistovna(){
        $stmt = $this->pdo->prepare('SELECT jmeno FROM pojistovna');
        $stmt->execute(array());
        return $stmt->fetchAll();
    }

    function getWealth($koho){
        $stmt = $this->pdo->prepare('SELECT Penize FROM pobocka WHERE id = ?');
        $stmt->execute(array($koho));
        $res = $stmt->fetch();
        return $res['Penize'];
    }

    function addPobocka($jmeno,$mesto, $ulice, $cislo, $PSC,  $Penize){
        $stmt = $this->pdo->prepare('INSERT INTO pobocka (jmeno, mesto, ulice, cislo, PSC, Penize) VALUES(?,?,?,?,?,?)');
        $stmt->execute(array($jmeno,$mesto, $ulice, $cislo, $PSC,  $Penize));
    }


    function getTransactions(){
        $stmt = $this->pdo->prepare('SELECT prodal.kdy cas, prodal.kdo login, prodal.komu RC, zakaznik.jmeno jmeno, zakaznik.prijmeni prijmeni, pojistovna.jmeno pojistovna, lek.jmeno lek, prodal.kolik kolik FROM prodal, zakaznik, pojistovna, lek WHERE prodal.komu = zakaznik.RC AND prodal.pojistovna=pojistovna.id AND prodal.co=lek.id');
        $stmt->execute(array());
        return $stmt->fetchAll();
}

    function getAllZamestnanec(){
        $stmt = $this->pdo->prepare('SELECT uzivatel.login, uzivatel.jmeno, uzivatel.prijmeni, uzivatel.telefon, uzivatel.email, uzivatel.postaveni, pobocka.jmeno pobocka FROM uzivatel, pobocka WHERE uzivatel.pobocka =pobocka.id');
        $stmt->execute(array());
        return $stmt->fetchAll();

    }

    function rmvMed($kde, $co, $kolik){
        $stmt = $this->pdo->prepare('SELECT pocet FROM skladem WHERE pobocka = ? AND lek = ?');
        $stmt->execute(array($kde, $co));
        $result = $stmt->fetch();
        $result = $result['pocet'];
        $result -= $kolik;
        $stmt = $this->pdo->prepare('UPDATE skladem SET pocet = ? WHERE pobocka = ? AND lek = ?');
        $stmt->execute(array($result,$kde,$co));
    }

    function addPerson($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, surname) VALUES (:name, :surname)');
        if ($stmt->execute($data))
        {
            $newid = $this->pdo->lastInsertId();
            $data['id'] = $newid;
            return $data;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }
    
    function updatePerson($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name = :name, surname = :surname WHERE id = :id');
        if ($stmt->execute($data))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }
    
    function deletePerson($id)
    {
        $arr['id']=$id;
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        if ($stmt->execute($arr[id]))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

}
