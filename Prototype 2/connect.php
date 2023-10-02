<?php
class Dbh {
    private $host = 'localhost';
    private $user = 'root';
    private $dbName = 'arbre_comptences';
    private $passwrod = '';

    public function connect(){
        try{
           $dsn = 'mysql:host='. $this->host . ';dbname=' . $this->dbName;
           $conn = new PDO($dsn,$this->user,$this->passwrod);
           $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
           return $conn;
        }catch(PDOException $e){
        echo'connection failed' . $e->getMessage();
            }
    }
}
?>