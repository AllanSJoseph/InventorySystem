<?php

class Database{

    private $host = "localhost";
    private $username = "miniproject";
    private $password = "miniproject123";
    private $dbname = "inventory";

    protected $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host,$this->username,$this->password,$this->dbname);

        if ($this->conn->connect_error){
            die("Connection failed: ".$this->conn->connect_error);
        }
    }
}