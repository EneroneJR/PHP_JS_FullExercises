<?php
include "test.php";

$conn = OpenCon();

echo $_SERVER["HTTP_EDATE"];
/*
$_SESSION["sDate"] = $_SERVER["HTTP_SDATE"];
$_SESSION["eDate"] = $_SERVER["HTTP_EDATE"];
$_SESSION["name"] = $_SERVER["HTTP_NAME"];
$_SESSION["surname"] = $_SERVER["HTTP_SURNAME"];
$_SESSION["mail"] = $_SERVER["HTTP_MAIL"];

echo " " . $_SESSION["sDate"] . " " . $_SESSION["eDate"] . " " . $_SESSION["name"] . " " .
    $_SESSION["surname"] . " " . $_SESSION["mail"];
*/


CloseCon($conn);
?>