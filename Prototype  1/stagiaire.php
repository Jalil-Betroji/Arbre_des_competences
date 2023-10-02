<?php
require_once './connect.php';
include_once './gestionStagiaire.php';

class Gestion
{
  public $conn;
  public function __construct($dbh){
    $this->conn = $dbh->connect();
  }
  public function getStagaireInfo()
  {
    $data = $this->conn->prepare('SELECT * FROM personne');
    if (!$data->execute()) {
      $data = null;
      exit();
    }
    $stagiaireInfo = $data->fetchAll(PDO::FETCH_ASSOC);
    // return $stagiaireInfo;
    $StagaireInfoArray = [];
    foreach ($stagiaireInfo as $stagiaireDataValues) {
      $stagiaire = new Stagiaire();
      $stagiaire->setId($stagiaireDataValues['Id']);
      $stagiaire->setName($stagiaireDataValues['Nom']);
      array_push($StagaireInfoArray, $stagiaire);
    }
    return $StagaireInfoArray;
  }
}
$dbh = new Dbh();
$newData = new Gestion($dbh);
$stagiaireData = $newData->getStagaireInfo();

?>