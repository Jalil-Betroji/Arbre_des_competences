<?php
/**
 * User: Arif Uddin
 * Date: 4/6/12
 * Time: 4:14 PM
 */
 
class InternDTO {

    private $id;
    private $name;
    private $cne;
    private $city;
    function __construct($id, $name , $cne , $city) {
        $this->id = $id;
        $this->name = $name;
        $this->cne = $cne;
        $this->city = $city;
    }

    public function GetId() { return $this->id; }
    public function GetName() { return $this->name; }
    public function GetCNE() { return $this->cne; }
    public function GetCity() { return $this->city; }
}
