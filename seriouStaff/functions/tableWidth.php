<?php
if(isset($_POST["width"]) && $_POST["width"] != NULL)
{
    $_SESSION["width"] = $_POST["width"];
    header('Location: ' . '../seriouStaff/index.php');
}
?>