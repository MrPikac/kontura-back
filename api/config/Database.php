<?php


class Database
{
    private $hostName;
    private $dbName;
    private $userName;
    private $password;

    private $conn;

    public function connect(){
        $this->hostName = "localhost";
        $this->dbName = "construction_company_db";
        $this->userName = "root";
        $this->password = "";
        $this->conn = new mysqli($this->hostName,$this->userName,$this->password,$this->dbName);

        if($this->conn->connect_errno){
            print_r($this->conn->connect_error);
            exit;
        } else {
            return $this->conn;
        }
    }



}
/*
$db = new Database();
$db->connect();*/