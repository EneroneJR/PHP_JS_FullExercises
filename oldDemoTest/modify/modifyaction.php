<?php
include '../test.php';
$conn = OpenCon();
$oldmail = $_GET["oldMail"];

$email = $_GET["email"];
$name = $_GET["name"];
$surname = $_GET["surname"];
$password = $_GET["password"];

$sql = "UPDATE test SET email = '$email', name = '$name', surname = '$surname', password = '$password' WHERE email = '$oldmail'";

if($conn -> query($sql) === TRUE)
{
    echo "Dati aggiornati con successo";
}else{
    echo "errore nell'aggiornamento: " . $conn->error;
}

echo "<br/><br/><br/><br/>";

echo "
    <form action=\"/demo/table.php\" method=\"GET\">
        <button type=\"submit\">torna indietro</button>
    </form>
    ";

CloseCon($conn);
?>