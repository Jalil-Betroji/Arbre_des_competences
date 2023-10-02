<?php
include_once '../Entity/trainees.php';
include_once '../DB/traineesManagment.php';

$traineeDataManagment = new TraineesManagment();

if(isset($_POST['confirm_Data'])){
    $addTrainee = new Trainees();
    $addTrainee->setId($_POST['personId']);
    $addTrainee->setName($_POST['name']);
    $addTrainee->setCNE($_POST['cne']);
    $addTrainee->setCity($_POST['city']);
    $traineeDataManagment->addTrainee($addTrainee);
}
if (isset($_POST['confirm_Update'])) {

    $update = new Trainees();
    $update->setId($_POST['personId']);
    $update->setName($_POST['name']);
    $update->setCNE($_POST['cne']);
    $update->setCity($_POST['city']);
    $traineeDataManagment->updateTrainner($update);
    header("Location: ../Presentation/index.php");
}
if (isset($_POST['confirm_delete'])) {
    $delete = new Trainees();
    $delete->setId($_POST['delete_id']);
    $traineeDataManagment->deleteTrainner($delete);
    header("Location: ../Presentation/index.php");
}
?>