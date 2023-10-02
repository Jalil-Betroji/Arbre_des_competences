<?php

require_once('loader.php');

$internBllObj = new InternBLL();
$deleteSuccess = false;
$addSuccess = false;
$updateSuccess = false;
$errorMessage = '';

$countedInterns = new InternDAL();
$counted = $countedInterns->countInterns();

$dataPoints = [];
foreach ($counted as $city) {
    $dataPoint = array(
        "y" => $city["TrainerCount"],
        "label" => $city["VilleNom"]
    );
    array_push($dataPoints, $dataPoint);
}

if (isset($_POST['confirm_Update']) && isset($_POST['confirm_Update']) == 'Editer') {
    $internBllObj = new InternBLL();
    $internId = $_POST['personId'];
    $InternName = $_POST['name'];
    $internCNE = $_POST['cne'];
    $internCity = $_POST['city'];

    $anIntern = new InternDTO($internId, $InternName, $internCNE, $internCity);
    $updateResult = $internBllObj->UpdateIntern($anIntern);

    if ($updateResult > 0) {
        $updateSuccess = true;
    } else {
        if ($internBllObj->errorMessage != '') {
            $errorMessage = $internBllObj->errorMessage;
        } else {
            $errorMessage = 'Record can\'t be updated. Operation failed.';
        }
    }

} elseif (isset($_GET['id']) && (int) $_GET['id'] > 0) {

    $internId = (int) $_GET['id'];
    $action = '';
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

    $internBllObj = new InternBLL();
    $anIntern = $internBllObj->GetStudent($internId);

    if ($action == 'add') {
        $addSuccess = true;
    }

} else {
    // header("Location: index.php");
}
if (isset($_POST['confirm_Data']) && $_POST['confirm_Data'] == 'Confirmer') {

    $internBllObj = new InternBLL();
    $InternName = $_POST['name'];
    $internCNE = $_POST['cne'];
    $internCity = $_POST['city'];

    $newIntern = new InternDTO(0, $InternName, $internCNE, $internCity);
    $addInternResult = $internBllObj->AddIntern($newIntern);

    if ($addInternResult > 0) {
        $addSuccess = true;
    } else {
        if ($internBllObj->errorMessage != '') {
            $errorMessage = $internBllObj->errorMessage;
        } else {
            $errorMessage = 'Record can\'t be added. Operation failed.';
        }
    }
}

if (isset($_POST['confirm_delete'])) {

    $internId = (int) $_POST['delete_id'];

    $deleteResult = $internBllObj->DeleteIntern($internId);

    if ($deleteResult > 0) {
        $deleteSuccess = true;
    } else {
        if ($internBllObj->errorMessage != '') {
            $errorMessage = $internBllObj->errorMessage;
        } else {
            $errorMessage = 'Record can\'t be deleted. Operation failed.';
        }
    }
}
$allInterns = $internBllObj->GenerateHtmlForAllInterns();
$pageTitle = "Student Information";
include_once("Templates/header.php");

?>

<div class="page-header">
    <h1>List of Interns</h1>
</div>

<?php if ($deleteSuccess === true): ?>
    <div class="alert alert-success">Record deleted successfully.</div>
<?php endif; ?>
<?php if ($addSuccess === true): ?>
    <div class="alert alert-success">Record Added successfully.</div>
<?php endif; ?>
<?php if($updateSuccess === true):?>
    <div class="alert alert-success">Record Updated successfully.</div>
    <?php endif;?>
<?php if ($errorMessage != ''): ?>
    <div class="alert alert-danger">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<?php

echo $allInterns;

include_once("Templates/footer.php");

?>