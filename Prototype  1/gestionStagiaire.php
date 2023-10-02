<?php
class Stagiaire {
    private $Id;
    private $Name;
    private $CNE;
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
      $this->Name = $cne;
   }
   public function getCNE(){
      return $this->CNE;
   }
}
?>