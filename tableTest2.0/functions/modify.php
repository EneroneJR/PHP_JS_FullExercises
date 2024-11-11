<?php
include '../test.php';
$conn = OpenCon();

$email = $_GET["email"];

$sql = "SELECT email, name, surname, password, datainizio, datafine FROM test WHERE email = '$email'";

$result = $conn->query($sql);

if($result->num_rows != null )
{
    $row = $result->fetch_assoc();
?>
<h1>Scrivere il valore che si vuole cambiare nella casella sotto</h1>
<table>
    <tr>
        <td>Email</td>
        <td>Nome</td>
        <td>Cognome</td>
        <td>password</td>
        <td>Data Inizio</td>
        <td>Data Fine</td>
    </tr>
    <?php
    echo "
    <form action=\"/demo/modify/modifyaction.php\" method=\"GET\">
    <div>
        <tr>
            <td>
                <input type=\"text\" value=\"" . $row["email"] . "\" name=\"email\">
            </td>
            <td>
                <input type=\"text\" value=\"" . $row["name"] . "\" name=\"name\">
            </td>
            <td>
                <input type=\"text\" value=\"" . $row["surname"] . "\" name=\"surname\">
            </td>
            <td>
                <input type=\"text\" value=\"" . $row["password"] . "\" name=\"password\">
            </td>
            <td>
                <input type=\"text\" value=\"" . $row["datainizio"] . "\" name=\"datainizio\">
            </td>
            <td>
                <input type=\"text\" value=\"" . $row["datafine"] . "\" name=\"datafine\">
            </td>
        </tr>
        <tr>
            <td>
            <input type=\"submit\"> 
            </td>
        </tr>
        <input type=\"hidden\" value=\"" . $row["email"] . "\" name = \"oldMail\">
    </div>
    </form>
</table>
<input type=\"hidden\" value=\"" . $row["email"] . "\" name = \"oldMail\">
";
    ?>
<?php
}

CloseCon($conn);
?>