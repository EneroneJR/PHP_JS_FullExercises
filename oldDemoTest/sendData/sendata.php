<?php
include '../test.php';
/*
$name = $_POST["name"];
$surname = $_POST["surname"];
$password = $_POST["password"];
$email = $_POST["email"];
*/


$name = $_SERVER["HTTP_NAME"]; // Server è una super global. ed HTTP_ è il metodo che indica che voglio prendere un header
$surname = $_SERVER["HTTP_SURNAME"]; // dopo "_" sta il nome/chiave dell'header con il valore che cerchiamo
$password = $_SERVER["HTTP_PASSWORD"]; // Per qualche ragione è tutto in CAPS_LOCK
$email = $_SERVER["HTTP_EMAIL"];

$conn = OpenCon();

$sql = "INSERT INTO test(email,name,surname,password) VALUES ('$email','$name','$surname','$password')";

if($conn->query($sql) === TRUE){
    echo "200 dati inseriti correttamente";
}else{
    echo "404 Errore inaspettato<br><br>" . $conn->error;
}

CloseCon($conn);
?>