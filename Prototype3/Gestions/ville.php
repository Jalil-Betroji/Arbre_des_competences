<?php 
require_once './connect.php';
include_once './Entity/stagiaires.php';

class Villes extends Dbh {
    private $City;
    public function setCity($city){
        $this->City = $city;
    }
    public function getCity(){
        return $this->City;
    }
    public function getCities(){
        $citiesNames = $this->connect()->prepare('SELECT * FROM ville');
        if(!$citiesNames->execute()){
            $citiesNames = null;
            exit();
        }
        $cityData = $citiesNames->fetchAll(PDO::FETCH_ASSOC);
        
      return $cityData;
    }
}
?>