<?php
if(isset($_GET["page"]) && $_GET["page"] != NULL)
{
    $_SESSION["page"] = $_GET["page"];
    header('Location: ' . '../seriouStaff/index.php');
}
?>