<?php

if(  // QUESTA È UN ALTERNATIVA PER EVITARE DI SCRIVERE A RIPETIZIONE "IF"
    isset($_POST["name"]) && $_POST["name"] != NULL
    &&
    isset($_POST["surname"]) && $_POST["surname"] != NULL
    &&
    isset($_POST["password"]) && $_POST["password"] != NULL
    &&
    isset($_POST["email"]) && $_POST["email"] != NULL
    &&
    isset($_POST["sdate"]) && $_POST["sdate"] != NULL
    &&
    isset($_POST["edate"]) && $_POST["edate"] != NULL
    )
{
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $sdate = $_POST["sdate"];
    $edate = $_POST["edate"];
    echo $name . '{}' . $surname . '{}' . $password . '{}' . $email . '{}' . $sdate . '{}' . $edate . '{}';
/*
$name = $_SERVER["HTTP_NAME"]; // Server è una super global. ed HTTP_ è il metodo che indica che voglio prendere un header
$surname = $_SERVER["HTTP_SURNAME"]; // dopo "_" sta il nome/chiave dell'header con il valore che cerchiamo
$password = $_SERVER["HTTP_PASSWORD"]; // Per qualche ragione è tutto in CAPS_LOCK
$email = $_SERVER["HTTP_EMAIL"];
*/

    $sql = "INSERT INTO test(email,name,surname,password,datainizio,datafine) VALUES ('$email','$name','$surname','$password','$sdate','$edate')";

    if($conn->query($sql) === TRUE){

        header('Location: ' . '../seriouStaff/index.php');
        die(); 
    //exit();
    // queste funzioni servono per chiudere il file prima di fare altro, però in questo caso è meglio se la connessione venga chiusa in sicurezza
    //echo "200 dati inseriti correttamente";
    }else{
        echo "404 Errore inaspettato<br><br>" . $conn->error;
    }
}
?>