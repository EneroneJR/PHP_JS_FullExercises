<?php
if(  // QUESTA È UN ALTERNATIVA PER EVITARE DI SCRIVERE A RIPETIZIONE "IF"
    isset($_GET["name"]) && $_GET["name"] != NULL
    &&
    isset($_GET["surname"]) && $_GET["surname"] != NULL
    &&
    isset($_GET["password"]) && $_GET["password"] != NULL
    &&
    isset($_GET["email"]) && $_GET["email"] != NULL
    &&
    isset($_GET["sdate"]) && $_GET["sdate"] != NULL
    &&
    isset($_GET["edate"]) && $_GET["edate"] != NULL
    &&
    isset($_GET["modify"]) && $_GET["modify"] == "modify"
    )
{
    $name = $_GET["name"];
    $surname = $_GET["surname"];
    $password = $_GET["password"];
    $email = $_GET["email"];
    $sdate = $_GET["sdate"];
    $edate = $_GET["edate"];

    $sql = "UPDATE test SET name = '$name', surname = '$surname', password = '$password', datainizio = '$sdate', datafine = '$edate' WHERE email = '$email'";

    if($conn->query($sql) === TRUE)
    {
        header('Location: ' . '../seriouStaff/index.php');
        die(); 
    //exit();
    // queste funzioni servono per chiudere il file prima di fare altro, però in questo caso è meglio se la connessione venga chiusa in sicurezza
    //echo "200 dati inseriti correttamente";
    }else
    {
        echo "404 Errore inaspettato<br><br>" . $conn->error;
    }
}
?>