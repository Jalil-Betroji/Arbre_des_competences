<?php
class Trainees {
    private $Id;
    private $Name;
    private $CNE;
    private $City;
    public function setId($id){
        $this->Id = $id;
    }
    public function getId(){
        return $this->Id;
    }
    public function setName($name){
        $this->Name = $name;
    }
    public function getName(){
        return $this->Name;
    }
    public function setCNE($cne){
        $this->CNE = $cne;
    }
    public function getCNE(){
        return $this->CNE;
    }
    public function setCity($city){
        $this->City = $city;
    }
    public function getCity(){
        return $this->City;
    }
}
?>