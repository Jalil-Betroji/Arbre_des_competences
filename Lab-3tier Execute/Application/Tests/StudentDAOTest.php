<?php
// test tout les méthodes
require_once '../../loader.php';

$testFunctions = new StudentDAO();

$printData = $testFunctions->GetAllStudents();
print_r($printData);
?>