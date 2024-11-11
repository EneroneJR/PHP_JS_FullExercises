<?php
include '../test.php';

$mail = $_GET["email"];
$conn = OpenCon();

$sql = "DELETE FROM test WHERE email = '$mail'";

if($conn->query($sql) === TRUE)
{
    echo "Cancellazione avvenuta con successo";
}else{
    echo "Errore nella cancellazione: " . $conn->error;
}

echo "<br/><br/><br/><br/>";

echo "
    <form action=\"/demo/TableTest2.0/table.php\" method=\"GET\">
        <button type=\"submit\">torna indietro</button>
    </form>
    ";

    CloseCon($conn);
?>