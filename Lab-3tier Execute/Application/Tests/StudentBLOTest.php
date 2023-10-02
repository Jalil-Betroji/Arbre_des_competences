<?php
// test tout les méthodes
require_once '../../loader.php';

$testFunctions = new StudentBLO();

$printData = $testFunctions->GetAllStudents();
print_r($printData);
?>