<?php

require_once('loader.php');

$studentBllObj = new StudentBLO();
$deleteSuccess = false;
$errorMessage = '';

if( isset($_REQUEST['delete']) && $_REQUEST['delete']=='yes' ) {

    $studentId = (int)$_REQUEST['id'];
    $deleteResult = $studentBllObj->DeleteStudent($studentId);

    if($deleteResult > 0) {
        $deleteSuccess = true;
    } else {
        if ($studentBllObj->errorMessage != '') {
            $errorMessage = $studentBllObj->errorMessage;
        } else {
            $errorMessage = 'Record can\'t be deleted. Operation failed.';
        }
    }
}


function GenerateHtmlForAllStudents() {
    $studentBlo = new StudentBLO();
    $all_students_html = '';
    $all_students = $studentBlo->GetAllStudents();
    
    if( count($all_students) > 0 ) {
        
        $all_students_html .= '<table class="table table-bordered">';
        
        $all_students_html .= '<tr>';
        $all_students_html .= '<th>Name</th>';
        $all_students_html .= '<th>Email</th>';
        $all_students_html .= '<th>Date of Birth</th>';
        $all_students_html .= '<th class="center" colspan="2">Action</th>';
        $all_students_html .= '</tr>';
        
        foreach($all_students as $student) {
            $all_students_html .= '<tr>';
                $all_students_html .= '<td>'. $student->GetName() .'</td>';
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





$pageTitle = "Student Information";
include_once("Templates/header.php");

$allStudents = GenerateHtmlForAllStudents();

?>

<div class="page-header">
    <h1>List of Students</h1>
</div>

<?php if ($deleteSuccess === true): ?>
<div class="alert alert-success">Record deleted successfully.</div>
<?php endif; ?>
<?php if ($errorMessage != ''): ?>
    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
<?php endif; ?>

<?php

echo $allStudents;

include_once("Templates/footer.php");

?>