<?php
class DatabaseConnection
{

    private $dbHost = 'localhost';
    private $dbName = 'arbre_comptences';
    private $user = 'root';
    private $password = '';
    public function connect()
    {
        try {
            $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $conn = new PDO($dsn, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            echo'connection failed' . $e->getMessage();
        }
    }


}
?>