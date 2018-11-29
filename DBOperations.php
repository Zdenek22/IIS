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
            $stmt = $this->pdo->prepare('SELECT lek.jmeno, lek.cena, lek.predpis, lek.popis, skladem.pocet  FROM lek, skladem WHERE skladem.pobocka= ? AND lek.id = skladem.lek AND lek.jmeno=?');
            $stmt->execute(array($idPobocky, $jmeno));
            return $stmt->fetchAll();
        }
    }
    
    //vraci seznam OTEVRENYCH rezervaci na zadane pobocce
    function getReservations($idPobocky)
    { 
            $null=null;
            $stmt = $this->pdo->prepare('SELECT rezervace.id, rezervace.vytvoril, rezervace.pojistovna, rezervace.RC, pobocka.jmeno  FROM rezervace, pobocka WHERE rezervace.pobocka= ? AND rezervace.pobocka = pobocka.id AND rezervace.ukoncil is null LIMIT 100');
            $stmt->execute(array($idPobocky));
            return $stmt->fetchAll();
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
