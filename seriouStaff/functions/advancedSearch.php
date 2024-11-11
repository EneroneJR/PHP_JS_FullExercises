<?php
include 'test.php';
session_start();

$_SESSION["KeyWord"] = $_SERVER["HTTP_KEYWORD"];

$conn = Opencon();

$sql = "SELECT email, name, surname, password, datainizio, datafine FROM test WHERE email LIKE '%" . $_SESSION["KeyWord"] . "%' OR name LIKE '%" . $_SESSION["KeyWord"] . "%' OR surname LIKE '%". $_SESSION["KeyWord"] . "%'";
// i % servono per indicare che sia a destra, che a sinistra, potrebbero esserci altre parole utili

$result = $conn->query($sql);

if($result->num_rows != null )
{
    $json = array();
    while($row = $result->fetch_assoc()) // questo è come si integra un file "dinamico" come grandezza
    {
        $json[] = $row;
    }
    echo json_encode($json);
}else
{
    echo "0 risultati o errore";
}

CloseCon($conn);
?>