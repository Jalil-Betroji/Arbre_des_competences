<?php

/**
 * Class for database interaction
 */
class InternDAL
{

    private $db;
    private $databaseConnectionObj;

    /**
     * Connect to the database. Create an instance of database object.
     */
    public function __construct()
    {
        $this->databaseConnectionObj = new DatabaseConnection();
        $this->db = $this->databaseConnectionObj->connect();
    }

    /**
     * Get All students
     *
     * @return array
     */
    public function GetAllInterns()
    {

        $sql = "SELECT personne.Id, personne.Nom, personne.CNE, ville.Nom AS VilleNom
        FROM personne
        INNER JOIN ville ON personne.Ville_Id = ville.Id;";
        $raw_result = $this->db->prepare($sql);

        if (!$raw_result->execute()) {
            $raw_result = null;
            exit();
        }


        $allTraineesData = $raw_result->fetchAll(PDO::FETCH_ASSOC);
        $allTraineesDataArray = [];
        foreach ($allTraineesData as $traineeData) {
            $traineeInfo = new InternDTO($traineeData['Id'], $traineeData['Nom'], $traineeData['CNE'], $traineeData['VilleNom']);

            array_push($allTraineesDataArray, $traineeInfo);
        }
        return $allTraineesDataArray;

    }

    /**
     * Get a student
     *
     * @param int $inetrnId
     * @return array
     */
    public function countInterns()
    {
        $stm = $this->db->prepare('SELECT ville.Id, ville.Nom AS VilleNom, COUNT(personne.Id) AS TrainerCount
        FROM personne
        INNER JOIN ville ON personne.Ville_Id = ville.Id
        GROUP BY ville.Id, ville.Nom;');
        if (!$stm->execute()) {
            $stm = null;
            exit();
        }
        $countedTrainees = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $countedTrainees;
    }

    /**
     * Insert New Student
     *
     * @param object $studentDto
     * @return int
     */
    public function AddIntern($studentDto)
    {

        $sql = "INSERT INTO personne (`Nom`, `CNE`, `Ville_Id`)
                VALUES (
                  '" . $studentDto->GetName() . "',
                  '" . $studentDto->GetCNE() . "',
                  '" . $studentDto->GetCity() . "'
                )";
        $stm = $this->db->prepare($sql);

       $stm->execute();
       $lastInsertId = $this->db->lastInsertId();

       return $lastInsertId;
    }

    /**
     * Updates existing Student
     *
     * @param object $studentDto
     * @return bool|int
     */
    public function UpdateIntern($studentDto)
    {

        $sql = "UPDATE personne
                SET
                    Nom='" . $studentDto->GetName() . "',
                    CNE='" . $studentDto->GetCNE() . "',
                    Ville_Id='" . $studentDto->GetCity() . "'
                WHERE Id=" . $studentDto->GetId();

        return $this->db->prepare($sql)->execute();
    }

    /**
     * Deletes a student from the database
     *
     * @param $inetrnId
     * @return int|void
     */
    public function DeleteIntern($inetrnId)
    {

        $sql = "DELETE FROM personne WHERE Id=" . $inetrnId;

        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->rowCount();
    }
    /**
     * Checks whether given Roll exists or not
     *
     * @param string $cne
     * @param int $id
     * @return bool
     */
    public function IsCNEExists($cne, $id = 0)
    {

        $sql = "SELECT * FROM personne WHERE CNE='" . $cne . "' AND Id != $id";
        $raw_result = $this->db->prepare($sql);
        $raw_result->execute();

        if ($raw_result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks whether given Id exists or not
     *
     * @param int $id
     * @return bool
     */
    public function IsIdExists($id)
    {

        $sql = "SELECT * FROM personne WHERE Id = $id";
        $raw_result = $this->db->prepare($sql);
        $raw_result->execute();
        if ($raw_result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}