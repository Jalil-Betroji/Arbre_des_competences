<?php
class Cities extends Dbh {
   public function getCitiesList(){
    $stm = $this->connect()->prepare('SELECT * FROM ville');
    if(!$stm->execute()){
        $stm = null;
        exit();
    }
    $citiesNamesData = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $citiesNamesData;
   }
}
?>