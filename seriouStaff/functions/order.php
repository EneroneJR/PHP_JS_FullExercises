<?php
if(isset($_GET["order"]) && $_GET["order"] != NULL)
{
    if(isset($_SESSION["orderWord"]) && $_SESSION["orderWord"] == $_GET["order"])
    {
        // Codice per renderlo ascendente
        if(isset($_SESSION["orderType"]) && $_SESSION["orderType"] != "DESC")
        {
            $_SESSION["orderType"] = "DESC";
        }else
        {
            $_SESSION["orderType"] = "ASC";
        }
    }else{
        $_SESSION["orderWord"] = $_GET["order"];
        $_SESSION["orderType"] = "ASC";
    }
    header('Location: ' . '../seriouStaff/index.php');
}
?>