<?php
class CitiesDAL {
    private $db;
    private $databaseConnectionObj;

    /**
     * Connect to the database. Create an instance of database object.
     */
    public function __construct() {
        $this->databaseConnectionObj = new DatabaseConnection();
        $this->db = $this->databaseConnectionObj->connect();
    }

    public function getAllCities(){
        $sql = 'SELECT * FROM ville';
        $stm = $this->db->prepare($sql);
        if(!$stm->execute()){
            $stm = null;
            exit();
        }
        $allCities = $stm->fetchAll(PDO::FETCH_ASSOC);
        $allCitiesArr = [];
        foreach($allCities as $cityData){
            $cityInfo = new InternDTO($cityData['Id'] ,'','', $cityData['Nom']);
            array_push($allCitiesArr , $cityInfo);
        }
        return $allCitiesArr;

    }

}
?>