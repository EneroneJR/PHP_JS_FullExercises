<?php

if(isset($_GET["email"]) && $_GET["email"] != NULL && isset($_GET["delete"]) && $_GET["delete"] == "delete")
{
    $mail = $_GET["email"];
    $sql = "DELETE FROM test WHERE email = '$mail'";

    if($conn->query($sql) === TRUE)
    {
        header('Location: ' . '../seriouStaff/index.php');
        die();
    }else{
        echo "Errore nella cancellazione: " . $conn->error;
    }
}
?>