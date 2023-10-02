<?php

/**
 * Class for database interaction
 */
class StudentDAO
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
    public function GetAllStudents()
    {

        $sql = "SELECT * FROM Student";
        $raw_result = $this->db->prepare($sql);
        if (!$raw_result->execute()) {
            $raw_result = null;
            exit();
        }
        $allTraineesData = $raw_result->fetchAll(PDO::FETCH_ASSOC);
        $dataArr = [];
        foreach ($allTraineesData as $data) {
            $traineeInfo = new Student($data['Id'], $data['Roll'], $data['Name'], $data['Email'], $data['DateOfBirth']);
            array_push($dataArr, $traineeInfo);
        }

        return $dataArr;
    }

    /**
     * Get a student
     *
     * @param int $studentId
     * @return bool|\Student
     */
    public function GetStudent($studentId)
    {
        $sql = "SELECT * FROM Student WHERE Id = :studentId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();

        $aStudent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aStudent !== false) {
            $studentObj = new Student($aStudent['Id'], $aStudent['Roll'], $aStudent['Name'], $aStudent['Email'], $aStudent['DateOfBirth']);
            return $studentObj;
        }

        return false;
    }

    /**
     * Insert New Student
     *
     * @param object $student
     * @return int
     */
    public function AddStudent($student)
    {

        $sql = "INSERT INTO Student (`Roll`, `Name`, `Email`, `DateOfBirth`)
                VALUES (
                  :roll,
                  :name,
                  :email,
                  :dateOfBirth
                )";

        $stmt = $this->db->prepare($sql);

        $roll = $student->GetRoll();
        $name = $student->GetName();
        $email = $student->GetEmail();
        $dateOfBirth = $student->GetDateOfBirth();

        $stmt->bindParam(':roll', $roll);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dateOfBirth', $dateOfBirth);

        $stmt->execute();

        $lastInsertId = $this->db->lastInsertId();

        return $lastInsertId;
    }

    /**
     * Updates existing Student
     *
     * @param object $student
     * @return bool|int
     */
    public function UpdateStudent($student)
    {

        $sql = "UPDATE Student
                SET
                    Roll='" . $student->GetRoll() . "',
                    Name='" . $student->GetName() . "',
                    Email='" . $student->GetEmail() . "',
                    DateOfBirth='" . $student->GetDateOfBirth() . "'
                WHERE Id=" . $student->GetId();

        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->rowCount();
    }

    /**
     * Search Student By Name
     *
     * @param string $studentName
     * @return array
     */
    public function SearchStudentByName($studentName)
    {
        $sql = "SELECT * FROM Student WHERE Name LIKE :studentName";
        $searchStudent = $this->db->prepare($sql);
        $searchStudent->bindValue(':studentName', '%' . $studentName . '%', PDO::PARAM_STR);
        $searchStudent->execute();
        $searchResults = $searchStudent->fetchAll(PDO::FETCH_ASSOC);
        $listOfStudent = [];
    
        foreach ($searchResults as $searched) {
            $id = $searched['Id'];
            $roll = $searched['Roll'];
            $name = $searched['Name'];
            $email = $searched['Email'];
            $dateOfBirth = $searched['DateOfBirth'];
    
            $student = new Student($id, $roll, $name, $email, $dateOfBirth);
            $listOfStudent[] = $student;
        }
    
        return $listOfStudent;
    }

    /**
     * Deletes a student from the database
     *
     * @param $studentId
     * @return int|void
     */
    public function DeleteStudent($studentId)
    {

        $sql = "DELETE FROM Student WHERE Id=" . $studentId;

        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->rowCount();
    }

    /**
     * Checks whether given Roll exists or not
     *
     * @param string $roll
     * @param int $id
     * @return bool
     */
    public function IsRollExists($roll, $id = 0)
    {

        $sql = "SELECT * FROM Student WHERE Roll='" . $roll . "' AND Id != $id";
        $raw_result = $this->db->prepare($sql);
        $raw_result->execute();
        $ifRoll = $raw_result->fetch();
        if ($ifRoll > 0) {
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

        $sql = "SELECT * FROM Student WHERE Id = $id";
        $raw_result = $this->db->prepare($sql);
        $raw_result->execute();
        if (!$raw_result->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks whether given Email exists or not
     *
     * @param string $email
     * @param int $id
     * @return bool
     */
    public function IsEmailExists($email, $id = 0)
    {

        $sql = "SELECT * FROM Student WHERE Email='" . $email . "' AND Id != $id";
        $raw_result = $this->db->prepare($sql);
        $raw_result->execute();
        $isEmail = $raw_result->fetch();
        if ($isEmail > 0) {
            return true;
        } else {
            return false;
        }
    }
}