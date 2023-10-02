<?php

class StudentBLL {

    private $studentDao;
    public $errorMessage;

    public function __construct() {
        $this->studentDao = new StudentDAO();
    }
  

    public function GetAllStudents() {
        return $this->studentDao->GetAllStudents();
    }

    public function GetStudent($studentId) {

        if($studentId <= 0) {
            // TODO: return type should be same datatype
            return false;
        }
        
        return $this->studentDao->GetStudent($studentId);
    }
  
    public function GenerateHtmlForAllStudents() {
        $all_students_html = '';
        $all_students = $this->studentDao->GetAllStudents();
        
        if( count($all_students) > 0 ) {
            
            $all_students_html .= '<table class="table table-bordered">';
            
            $all_students_html .= '<tr>';
            $all_students_html .= '<th>Name</th>';
            $all_students_html .= '<th>Roll</th>';
            $all_students_html .= '<th>Email</th>';
            $all_students_html .= '<th>Date of Birth</th>';
            $all_students_html .= '<th class="center" colspan="2">Action</th>';
            $all_students_html .= '</tr>';
            
            foreach($all_students as $student) {
                $all_students_html .= '<tr>';
                    $all_students_html .= '<td>'. $student->GetName() .'</td>';
                    $all_students_html .= '<td>'. $student->GetRoll() .'</td>';
                    $all_students_html .= '<td>'. $student->GetEmail() .'</td>';
                    $all_students_html .= '<td>'. $student->GetDateOfBirth() .'</td>';
                    $all_students_html .= '<td class="center"><a href="edit.php?id='. $student->GetId() .'">Edit</a></td>';
                    $all_students_html .= '<td class="center"><a onclick="return confirm(\'Do you really want to delete this record?\')" href="index.php?id='. $student->GetId() .'&delete=yes">Delete</a></td>';
                $all_students_html .= '</tr>';
            }

            $all_students_html .= '</table>';

        } else {
            $all_students_html = '<div class="alert alert-warning" role="alert">No student found. Try <a href="add.php">add</a> some.</div>';
        }

        return $all_students_html;
    }

    public function SearchStudentByName($studentName){
        return $this->studentDao->SearchStudentByName($studentName);
    }

    public function GenerateHtmlForSearchStudentByName($studentName) {

        $all_students_html = '';
        $search_student = $this->SearchStudentByName($studentName);

        if( $search_student > 0 ) {

            $all_students_html .= '<table class="table table-bordered">';

                $all_students_html .= '<tr>';
                    $all_students_html .= '<th>Name</th>';
                    $all_students_html .= '<th>Roll</th>';
                    $all_students_html .= '<th>Email</th>';
                    $all_students_html .= '<th>Date of Birth</th>';
                    $all_students_html .= '<th class="center" colspan="2">Action</th>';
                $all_students_html .= '</tr>';

            foreach($search_student as $student) {
                $all_students_html .= '<tr>';
                    $all_students_html .= '<td>'. $student->GetName() .'</td>';
                    $all_students_html .= '<td>'. $student->GetRoll() .'</td>';
                    $all_students_html .= '<td>'. $student->GetEmail() .'</td>';
                    $all_students_html .= '<td>'. $student->GetDateOfBirth() .'</td>';
                    $all_students_html .= '<td class="center"><a href="edit.php?id='. $student->GetId() .'">Edit</a></td>';
                    $all_students_html .= '<td class="center"><a href="index.php?id='. $student->GetId() .'&delete=yes">Delete</a></td>';
                $all_students_html .= '</tr>';
            }

            $all_students_html .= '</table>';
        }

        return $all_students_html;
    }

    public function AddStudent($student) {

        $insertedId = 0;

        if($student->GetName() == '' || $student->GetRoll() == '' || $student->GetEmail() == '') {
            $this->errorMessage = 'Student Name, Roll and Email is required.';
            return $insertedId;
        }

        if( $this->IsValidStudent($student) ) {
            $insertedId = (int)$this->studentDao->AddStudent($student);
        }

        return $insertedId;
    }

    public function UpdateStudent($student) {

        $affectedRows = 0;

        if($student->GetName() == '' || $student->GetRoll() == '' || $student->GetEmail() == '') {
            $this->errorMessage = 'Student Name, Roll and Email is required.';
            return $affectedRows;
        }

        if( $this->IsValidStudent($student) ) {
            $affectedRows = (int)$this->studentDao->UpdateStudent($student);
        }

        return $affectedRows;
    }

    public function SearchStudent($student) {

        $affectedRows = 0;

        if($student->GetName() == '') {
            return $affectedRows;
        } else {
            $affectedRows = $this->GenerateHtmlForSearchStudent($student);
        }

        return $affectedRows;
    }

    public function DeleteStudent($studentId) {

        $affectedRows = 0;
        
        if($studentId > 0) {
            if ($this->IsIdExists($studentId)) {
                $affectedRows = (int)$this->studentDao->DeleteStudent($studentId);
            } else {
                $this->errorMessage = 'Record not found.';
            }
        } else {
            $this->errorMessage = 'Invalid Id.';
        }

        return $affectedRows;
    }

    public function IsValidStudent($student) {
        if($this->IsRollExists( $student->GetRoll(), $student->GetId()) ) {
            $this->errorMessage = 'Roll '. $student->GetRoll() .' already exists. Try a different one.';
            return false;
        } elseif ( $this->IsEmailExists($student->GetEmail(), $student->GetId()) ) {
            $this->errorMessage = 'Email '. $student->GetEmail() .' already exists. Try a different one.';
            return false;
        } else {
            return true;
        }
    }

    public function IsIdExists($id) {
        return $this->studentDao->IsIdExists($id);
    }

    public function IsRollExists($roll, $id) {
        return $this->studentDao->IsRollExists($roll, $id);
    }

    public function IsEmailExists($email, $id) {
        return $this->studentDao->IsEmailExists($email, $id);
    }
}
