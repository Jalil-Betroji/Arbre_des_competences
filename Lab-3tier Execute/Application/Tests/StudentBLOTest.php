<?php
// test tout les méthodes
require_once '../../loader.php';

$testFunctions = new StudentBLO();

$printData = $testFunctions->GetStudent(1);
print_r($printData);
?>