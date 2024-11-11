<?php
include "../test.php";
$conn = OpenCon();

$sql = "SELECT * FROM `test`";

$result = $conn->query($sql);
// il ccodice qua sotto è vecchio. Questo serviva per passare la generazione di una tabella

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