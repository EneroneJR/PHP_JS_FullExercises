<?php
include 'test.php';

$conn = OpenCon();
echo "Connected Successfully";
?>
<br>
<!--		html stuff		-->
<h1>Inserimento dati</h1>
<br/>
<form action="/demo/sendData/sendata.php" method="POST"> <!-- Il form con action mi porterà sulla suddetta pagina -->
	<div>
		Nome: <input type="text" name="name"><br/>
		Cognome: <input type="text" name="surname"><br/>
		E-Mail: <input type="text" name="email"><br/>
		Password: <input type="text" name="password"><br/>
		<input type="submit">
	</div>
</form>
<br/><br/>
<form action="/demo/getData/getdata.php" method="GET">
	<div>
		Inserisci la tua email: <input type="text" name="email"><br/>
		<input type="submit">
	</div>
</form>
<br/><br/>
<form action="/demo/table.php" method="GET">
	<div>
		Premi questo pulsante se vuoi vedere tutta la tabella dati --->
		<input type="submit">
	</div>
</form>
<br/><br/>
<form action="/demo/search.php" method="GET">
	<div>
		Inserisci cosa la parola che cerchi: <input type="text" name="keyword">
		<input type="submit">
	</div>
</form>


<!--		chiusura html stuff		-->

<?php // questo php serve per chiudere
CloseCon($conn);
	/*
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
	*/
?>
<br/><br/>
Something is wrong with the XAMPP installation :-(
