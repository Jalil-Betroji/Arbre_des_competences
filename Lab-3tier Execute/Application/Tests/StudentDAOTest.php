<?php
/*===============================================
== test tout les méthodes
===============================================*/
require_once '../../loader.php';

$testFunctions = new StudentDAO();

/*===============================================
== tests Get All students
===============================================*/
function TestGetAllStudent() {
    $testFunctions = new StudentDAO();
    $AllStudents = $testFunctions->GetAllStudents();
    return $AllStudents;
}
// TestAddStudent();

/*===============================================
== // Tests fnction Get One Students
===============================================*/
function TestGetOneStudents() {
    $testFunctions = new StudentDAO();
    $getOneStudents = $testFunctions->GetStudent(1);
    return $getOneStudents;
}
// TestGetOneStudents();

/*===============================================
== // Tests fnction Add One Students
===============================================*/

function TestAddStudent() {
    $name = "Adnan";
    $email = "adnan@gmail.com";
    $date = date('Y-m-d H:i:s');
    $Student = new Student(0, $name, $email, $date);
    $testFunctions = new StudentDAO();
    $testFunctions->AddStudent($Student);
}
// TestAddStudent();

/*===============================================
== // test function update student
===============================================*/
function TestUpdateStudent() {
    $id = 3;
    $name = "AdnanO";
    $email = "adnan@gmail.com";
    $date = date('Y-m-d H:i:s');
    $Student = new Student($id, $name, $email, $date);
    $testFunctions = new StudentDAO();
    $testFunctions->AddStudent($Student);
}
// TestUpdateStudent();

/*===============================================
== // test function DELETE students
===============================================*/
function TestDeleteStudents($id) {
    $testFunctions = new StudentDAO();
    $testFunctions->DeleteStudent($id);
}
// TestDeleteStudents(2);

/*===============================================
== // test function 
===============================================*/
function TestCheackIdExists($id) {
    $testFunctions = new StudentDAO();
    $checkId =  $testFunctions->IsIdExists($id);
    return $checkId;
}
TestCheackIdExists(2);
?>