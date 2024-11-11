<?php
include '../test.php';

$conn = OpenCon();
$search = $_GET["email"];
$sql = "SELECT email, name, surname, password FROM test WHERE email = '$search'";

$result = $conn->query($sql);

if($result->num_rows != null )
{
    while($row = $result->fetch_assoc())
    {
        echo "Email: " . $row["email"] . " - Nome: " . $row["name"] . " - Cognome: " . $row["surname"] . " - Password: " . $row["password"] . "<br/><br/>";
    }
}else
{
    echo "0 risultati o errore";
}

CloseCon($conn);
?>