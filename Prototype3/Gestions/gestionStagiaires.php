<?php
require_once './connect.php';
include_once './Entity/stagiaires.php';
include_once './Gestions/ville.php';
class GestionStagiaire extends Dbh
{
    public function getStagiaireInfo()
    {
        $getData = $this->connect()->prepare('SELECT personne.Id, personne.Nom, personne.CNE, ville.Nom AS VilleNom
        FROM personne
        INNER JOIN ville ON personne.Ville_Id = ville.Id;');
        if (!$getData->execute()) {
            $getData = null;
            exit();
        }
        $stagiaireAllData = $getData->fetchAll(PDO::FETCH_ASSOC);
        $stagiaireData = [];
        foreach ($stagiaireAllData as $stagiaireValues) {
            $stagiaireValue = new Stagiaire();
            $stagiaireValue->setId($stagiaireValues['Id']);
            $stagiaireValue->setName($stagiaireValues['Nom']);
            $stagiaireValue->setCNE($stagiaireValues['CNE']);
            $VilleValue = new Villes();
            $VilleValue->setCity($stagiaireValues['VilleNom']);
            $stagiaireValue->setCity($VilleValue->getCity());


            array_push($stagiaireData, $stagiaireValue);
        }
       
        return $stagiaireData;

    }
    
    public function addStagiaire($manage){
        $name = $manage->getName();
        $cne = $manage->getCNE();
        $city = $manage->getCity();
        $type = 'stagiaire';
        $query ='INSERT INTO personne (Nom , CNE , Type , Ville_Id) VALUE (:nom , :cne , :type , :ville)';
        $stm = $this->connect()->prepare($query);
        $stm->bindParam(':nom', $name);
        $stm->bindParam(':cne', $cne);
        $stm->bindParam(':type', $type);
        $stm->bindParam(':ville', $city);
        $stm->execute();
    }
    public function updateTrainner($update){
       $id = $update->getId();
       $name = $update->getName();
       $cne = $update->getCNE();
       $city = $update->getCity();
       $query = 'UPDATE personne SET Nom = :name , CNE = :cne , Ville_Id = :ville WHERE Id=:id';
       $stm = $this->connect()->prepare($query);
       $stm->bindParam(':name',$name);
       $stm->bindParam(':cne' , $cne);
       $stm->bindParam(':ville' , $city);
       $stm->bindParam(':id' , $id);
       $stm->execute();
    }
    public function deleteTrainner($delete){
        $id = $delete->getId();
        $query = 'DELETE FROM personne WHERE Id = :id';
        $stm = $this->connect()->prepare($query);
        $stm->bindParam(':id' , $id);
        $stm->execute();
    }
    public function countTrainner(){
        $sql ="SELECT ville.Id, ville.Nom AS VilleNom, COUNT(personne.Id) AS TrainerCount
        FROM personne
        INNER JOIN ville ON personne.Ville_Id = ville.Id
        GROUP BY ville.Id, ville.Nom;";
        $stm = $this->connect()->prepare($sql);
        $stm->execute();
        $count = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $count;
    }
}
?>