<?php
require_once './connect.php';
include_once './entity/stagiaires.php';
class GestionStagiaire
{
    private $conn;
    public function __construct($dbh)
    {
        $this->conn = $dbh->connect();
    }
    public function getStagiaireInfo()
    {
        $getData = $this->conn->prepare('SELECT personne.Id, personne.Nom, personne.CNE
        FROM personne;');
        if (!$getData->execute()) {
            $getData = null;
            exit();
        }
        $stagiaireAllData = $getData->fetchAll(PDO::FETCH_ASSOC);
        $stagiaireData = [];
        foreach ($stagiaireAllData as $stagiaireValues) {
            $stagiaireValue = new Stagiaires();
            $stagiaireValue->setId($stagiaireValues['Id']);
            $stagiaireValue->setName($stagiaireValues['Nom']);
            $stagiaireValue->setCNE($stagiaireValues['CNE']);
            array_push($stagiaireData, $stagiaireValue);
        }
        return $stagiaireData;
    }
 
    public function addStagiaire($manage)
    {
        $name = $manage->getName();
        $cne = $manage->getCNE();
        $type = 'stagiaire';
        $query = 'INSERT INTO personne (Nom , CNE , Type ) VALUE (:nom , :cne , :type )';
        $stm = $this->conn->prepare($query);
        $stm->bindParam(':nom', $name);
        $stm->bindParam(':cne', $cne);
        $stm->bindParam(':type', $type);
        $stm->execute();
    }
    public function updateTrainner($update)
    {
        $id = $update->getId();
        $name = $update->getName();
        $cne = $update->getCNE();
        $query = 'UPDATE personne SET Nom = :name , CNE = :cne   WHERE Id=:id';
        $stm = $this->conn->prepare($query);
        $stm->bindParam(':name', $name);
        $stm->bindParam(':cne', $cne);
        $stm->bindParam(':id', $id);
        $stm->execute();
    }
    public function deleteTrainner($delete)
    {
        $id = $delete->getId();
        $query = 'DELETE FROM personne WHERE Id = :id';
        $stm = $this->conn->prepare($query);
        $stm->bindParam(':id', $id);
        $stm->execute();
    }
}
$dbh = new Dbh();
$stagiaireInitialData = new GestionStagiaire($dbh);
$stagiaireFullData = $stagiaireInitialData->getStagiaireInfo();
?>