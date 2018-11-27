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
    
    function getPeople()
    {
        $stmt = $this->pdo->query('SELECT id, name, surname FROM users LIMIT 100');
        return $stmt;
    }
    
    function getPerson($id)
    {
        $stmt = $this->pdo->prepare('SELECT login, heslo, jmeno, prijmeni, pobocka, email, telefon, postaveni FROM uzivatel WHERE login = ? AND heslo = ?');
        $stmt->execute(array($id[0],$id[1]));
        return $stmt->fetch();
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
