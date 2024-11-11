<?php

function OpenCon()
{
    $servername = "localhost";
    $username = "romano";
    $password = "Gianfranco100!";
    $db = "testromano";
    $conn = new mysqli($servername, $username, $password, $db) or die("Connection Failed %s\n". $conn -> error);
    return $conn;
}
function CloseCon($conn)
{
    $conn -> close();

    //echo "Messaggio di chiusura da esterno";
}
?>