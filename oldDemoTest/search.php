<?php
include 'test.php';

$keyword = $_GET["keyword"];

$conn = Opencon();

$sql = "SELECT email, name, surname, password FROM test WHERE email LIKE '%$keyword%' OR name LIKE '%$keyword%' OR surname LIKE '%$keyword%'";
// i % servono per indicare che sia a destra, che a sinistra, potrebbero esserci altre parole utili

$result = $conn->query($sql);

if($result != NULL){
    echo "Trovato un risultato: <br> ";
    $n = 1;
    while($row = $result->fetch_assoc())
    {
        echo "<h1>" . $n . ":</h1>";
        echo "Email: " . $row['email'] . 
        "<br/>Nome: " . $row['name'] . 
        "<br/>Cognome: " . $row['surname'] .
        "<br/>Password: " . $row['password'] . "<br/><br/><br/>";
        $n = $n + 1;
    }
}else{
    echo "Errore durante la ricerca: " . $conn->error;
}

CloseCon($conn);
?>