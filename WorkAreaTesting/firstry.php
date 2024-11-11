<?php
include "class.php";

$body = new RequestBody();

$url = "http://testservices.kedossrl.it/nemesiRest/oauth/token?grant_type=password&client_id=idUtente&client_secret=secretUtente&username=usernameUtente&password=passwordUtente";
$ch = curl_init();



//curl_setopt è una normale funzione che stabilisce le OPZIONI secondo le quali deve essere fatta la chiamata
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // qua ritorno il contenuto della pagine e con 1 gli dico "sì"

//curl_setopt($ch, CURLOPT_HTTPHEADER, $body); // Questo crea errore, poichè vuole per forza un array.

curl_setopt($ch, CURLOPT_HTTPHEADER, json_encode($body));

curl_setopt($ch, CURLOPT_URL, $url); // qua ritorno il valore dell'url designato

$result = curl_exec($ch);

echo $result;
?>