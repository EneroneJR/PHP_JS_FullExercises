<?php
if(isset($_GET["search"]) && $_GET["search"] == 'search')
{
    if(isset($_GET["sdateKey"]) && $_GET["sdateKey"] != NULL)
    {
        $_SESSION["sdate"] = $_GET["sdateKey"];
    }else{
        $_SESSION["sdate"] = "1800-01-01";
    }
    if(isset($_GET["edateKey"]) && $_GET["edateKey"] != NULL)
    {
        $_SESSION["edate"] = $_GET["edateKey"];
    }else
    {
        $_SESSION["edate"] = "3010-01-01";
    }
    if(isset($_GET["mailKey"]) && $_GET["mailKey"] != NULL)
    {
        $_SESSION["mail"] = $_GET["mailKey"];
    }else
    {
        $_SESSION["mail"] = "";
    }
    if(isset($_GET["nameKey"]) && $_GET["nameKey"] != NULL)
    {
        $_SESSION["name"] = $_GET["nameKey"];
    }else
    {
        $_SESSION["name"] = "";
    }
    if(isset($_GET["surnameKey"]) && $_GET["surnameKey"] != NULL)
    {
        $_SESSION["surname"] = $_GET["surnameKey"];
    }else
    {
        $_SESSION["surname"] = "";
    }
    header('Location: ' . '../seriouStaff/index.php');
}
?>