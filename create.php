<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$firsrname = null;
$lastname = null;
$errorMsg = array();

if (isset($_POST['submit'])) {

    $firsrname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if(empty($firsrname) || empty($lastname)) {
       // $errorMsg['firstname'] =  "<span style='color:#ff0000'> All fields are required.</span><br />";
        $errorMsg['firstname'] = "Error";
    }
    if (strlen($firsrname) > 45 || strlen($lastname) > 45) {
        //$errorMsg['firstname'] = '<span name="errorMsg" style="color:#ff0000">Your name length should be less than 45 characters</span><br />';
        $errorMsg['firstname'] = "error";
    }

}

$query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
$statement = $pdo->prepare($query);

$statement->bindValue(':firstname', $firsrname, \PDO::PARAM_STR);
$statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

$statement->execute();

header("Location: index.php");
