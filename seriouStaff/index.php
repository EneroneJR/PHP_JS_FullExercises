<?php
session_start();
include "functions/test.php";
$conn = OpenCon();
if(!isset($_SESSION["width"]))
{
    $_SESSION["width"] = "10";
}
if(!isset($_SESSION["page"]))
{
    $_SESSION["page"] = "1";
}
$totalCount = 0;
$elementCount = 0;
include "functions/sendata.php";
include "functions/deleteData.php";
include "functions/modify.php";
include "functions/search.php";
include "functions/order.php";
include "functions/pagination.php";
include "functions/tableWidth.php";

$query = "SELECT COUNT(*) AS total FROM `test`";

$sqlNumber = $conn->query($query);

if($sqlNumber) {
    $row = $sqlNumber->fetch_assoc();
    $totalCount = (int)$row['total'];
}

$sql1 = "SELECT COUNT(*) AS selezionati FROM ( SELECT * FROM `test` WHERE 1";


$sql = "SELECT * FROM `test` WHERE 1"; // puoi usare "AND" per continuare la query

if(isset($_SESSION["mail"]) && $_SESSION["mail"] != '')
{
    $key = $_SESSION["mail"]; 
    $sql .= " AND mail ='$key'";
    $sql1 .= " AND mail ='$key'";
}if(isset($_SESSION["name"]) && $_SESSION["name"] != '')
{
    $key = $_SESSION["name"];
    $sql .= " AND name ='$key'";
    $sql1 .= " AND name ='$key'";
}if(isset($_SESSION["surname"]) && $_SESSION["surname"] != '')
{
    $key = $_SESSION["surname"];
    $sql .= " AND surname ='$key'";
    $sql1 .= " AND surname ='$key'";
}if(isset($_SESSION["sdate"]))
{
    $sdate = $_SESSION["sdate"];
    if(isset($_SESSION["edate"]))
    {
        $edate = $_SESSION["edate"];

        $sql .= " AND datainizio >='$sdate' AND datafine <='$edate'";
        $sql1 .= " AND datainizio >='$sdate' AND datafine <='$edate'";
    }
}

$width = $_SESSION["width"];
$page = $_SESSION["page"];
$minpage = (int)$page -1;
//$maxpage = (int)$page;
$intWidth = (int)$width;
//$minlimit = $intWidth * $minpage;
//$maxlimit = $intWidth * $maxpage;
$offset = $minpage * $intWidth;

$addColumn = 0;

$addColumn = $totalCount % $intWidth;

if($addColumn != 0)
{
    $column = $totalCount / $intWidth;
    $column = $column+1;
}else
{
    $column = $totalCount / $intWidth;
}

$column = (int)$column;


if($page > $column || $page <= 0)
{
    $page = 1;
    $offset = 0;
}

if(isset($_SESSION["orderWord"]))
{
    if(isset($_SESSION["orderType"]))
    {
        $orderW = $_SESSION["orderWord"];
        $orderT = $_SESSION["orderType"];
        $sql .= " ORDER BY $orderW $orderT";
        $sql1 .= " ORDER BY $orderW $orderT";
    }
}

$sql .= " LIMIT $intWidth OFFSET $offset";
$sql1 .= " LIMIT $intWidth OFFSET $offset";

echo $sql . "<br>";
$sql1 .= ") AS subquery"; // DA RIPULIRE SQL1 visto che NON SERVE
echo $sql1 . "<br>";
/* 
$tempResult = $conn->query($sql1);
if($tempResult) {
    $row = $tempResult->fetch_assoc();
    if(isset($row['selezionati']))
    {
        $elementCount = (int)$row['selezionati'];
    }
}
*/

echo $column . "= <br>". $totalCount . " / " . $intWidth . "      " . $page;

$result = $conn->query($sql);


?>
<!--  HTML Area ================================================================================================================================================================ -->

<div>
    <!--
    <div>
        <table>
            <tr>
                <th class="searchTitle">Data Inizio:</th>
                <th>Data Fine:</th>
                <th>Email:</th>
                <th>Nome:</th>
                <th>Cognome:</th>
                <th>Password:</th>
            </tr>
            <tr>
                <td><input type="date" id="startDate"></td>
            </tr>
        </table>
    </div>
    -->
    <table>
        <thead>
        <!--
        <tr>
                <th class="searchTitle">Data Inizio:</th>
                <th>Data Fine:</th>
                <th>Email:</th>
                <th>Nome:</th>
                <th>Cognome:</th>
                <!--<th>Password:</th>
            </tr>
        -->
            <tr>
                <form action="/demo/seriouStaff/index.php" method="GET">
                    <td><input style="width:100%" type="date" id="startDate" value="1800-01-01" placeholder = "Search Start Date" name="sdateKey"></td>
                    <td><input style="width:100%" type="date" id="endDate" placeholder = "Search End Date" name="edateKey"></td>
                    <td><input style="width:100%" type="text" id="emailKey" value="<?php if(isset($_SESSION["mail"])){ echo $_SESSION["mail"];}?>" placeholder="Search E-Mail" name="mailKey"></td>
                    <td><input style="width:100%" type="text" id="nameKey" value="<?php if(isset($_SESSION["name"])){ echo $_SESSION["name"];}?>" placeholder="Search Name" name="nameKey"></td>
                    <td><input style="width:100%" type="text" id="surnameKey" value="<?php if(isset($_SESSION["surname"])){ echo $_SESSION["surname"];}?>" placeholder="Search Surname"name="surnameKey"></td>
                    <td><button type="submit" style="width:100%">Go</button></td>
                    <td class="btn"><input type="hidden" value="search" name="search"></td>
                </form>
            </tr>
            <tr>
                <form action="/demo/seriouStaff/index.php" method="GET">
                    <th><button type="submit" name="order" value="email">Email</button></th>
                    <th><button type="submit" name="order" value="name">Nome</button></th>
                    <th><button type="submit" name="order" value="surname">Cognome</button></th>
                    <th><button type="submit" name="order" value="password">Password</button></th>
                    <th><button type="submit" name="order" value="datainizio">Data Inizio</button></th>
                    <th><button type="submit" name="order" value="datafine">Data Fine</button></th>
                </form>
                <td colspan="2">
                    <input style="width:100%;" type="text" placeholder="Generic Dynamic Search" onkeyup="Search(this.value)">
                </td>
                <!--<th><button onclick="Conferma()">Search bar:</button></th>
                <th><input type="text" placeholder="Search" onkeyup="Search(this.value)"></th>-->
            </tr>
        </thead>
        <tbody id="dataTable">
            <?php
            
            // Genero la tabella

            if($result->num_rows != null )
            {
                $json = array();
                while($row = $result->fetch_assoc()) // questo è come si integra un file "dinamico" come grandezza
                {
                    echo "<tr>";
                    echo "<td>" . $row["email"] . "</td>"; 
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["surname"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
                    echo "<td>" . $row["datainizio"] . "</td>";
                    echo "<td>" . $row["datafine"] . "</td>";
                    if($row["email"] != null)
                    {
                        ?>
                            <td class="btn">
                                <button class="modify" onclick="modify('<?php print($row['email'])?>')">Modifica</button>
                            </td>
                            <td class = "btn">
                                <form action="/demo/seriouStaff/index.php" method="GET">
                                    <input type="hidden" value="<?php print($row["email"]) ?>" name="email">
                                    <input type="hidden" value="delete" name="delete"> 
                                    <button class="delete" type="submit">Elimina</button>
                                </form>
                            </td>
                        <?php
                    }               // Se si vuole sistemare il pulsante, dovrei togliere questi type "hidden" e magari inserirli in un form esterno che verrà richiamato tramite funzione JS
                    echo "</tr>";
                }
            }else
            {
                echo "0 risultati o errore";
            }
            ?>

        </tbody>
            <tr>
                <td class = "btn">
                    <button class="add" type="button" onclick="Show()">Aggiungi</button>    
                    <!-- Attualmente non funziona, da sistemare dopo -->
                </td>
                <td colspan="5" class="btn">
                    <form action="/demo/seriouStaff/index.php" method="GET" id="offset">
                        <div class="box">
                            <button type="button" class="prev"><a href="#">«</a></button>
                                <ul class="ul">
                                </ul>
                            <button type="button" class="next"><a href="#">»</a></button>
                        </div>
                        <input type="hidden" name = "page" id="currentPage" value="">
                    </form>
                </td>
            <!-- 
                <td>
                    Qua sto inserendo i bottoni per cambiare: pagina, lunghezza di elementi prendibili a pagina

                    <ul>
                        <li></li>
                    </ul>
                </td>
                <td>
                    <select></select>
                </td>
            -->
                <td class="btn" colspan="2">
                    <div style="text-align:right">
                        <label>Lunghezza:</label>
                        <form action="/demo/seriouStaff/index.php" method="POST">
                            <select name="width" id="width" onchange="this.form.submit()">
                                <option value="10" <?php if($width == 10) echo 'selected'; ?>>10</option>
                                <option value="3" <?php if($width == 3) echo 'selected'; ?>>3</option>
                                <option value="2" <?php if($width == 2) echo 'selected'; ?>>2</option>
                                <option value="1" <?php if($width == 1) echo 'selected'; ?>>1</option>
                            </select>
                        </form>
                    </div>
                </td>
            
            </tr>
    </table>
<!-- Questa parte è per aggiungere un utente -->
    <div>
        <br/><br/>
        <div>
            <p id="messagehelp">I dati sono stati inseriti correttamente</p>
            <div class = "addForm" id="addForm">
                    <form action="/demo/seriouStaff/index.php" method="POST">
                        <h1>Inserire i dati da aggiungere</h1>
                        Nome: <input type="text" name="name"><br/>
                        Cognome: <input type="text" name="surname"><br/>
                        E-Mail: <input type="text" name="email"><br/>
                        Password: <input type="text" name="password"><br/>
                        Data inizio: <input type="text" name="sdate" placeholder="1800-01-01"><br/>
                        Data Fine: <input type="text" name="edate" placeholder="1800-01-01"><br/>
                        <!--<input type="hidden" name="conn" value="<?php //echo $conn; ?>"><br/>-->
                        <button type="submit">invia</button>
                    </form>
                <button type="button" onclick="Show()">Indietro</button>
            </div>

            <div class = "modifyForm" id="modifyForm">
                <form action="/demo/seriouStaff/index.php" method="GET">
                    <h1>Inserire i dati da modificare</h1>
                    Nome: <input type = "text" name="name"><br/>
                    Cognome: <input type = "text" name="surname"><br/>
                    Password: <input type = "text" name="password"><br/>
                    Data Inizio: <input type = "text" name="sdate" placeholder="1800-01-01"><br/>
                    Data Fine: <input type = "text" name="edate" placeholder="1800-01-01"><br/>
                    <input type="hidden" value="" name="email" id="mail">
                    <input type="hidden" value="modify" name="modify">
                    <button type="submit"">Modifica</button>
                </form>
                <button type="button" onclick="ShowM()">Indietro</button>
            </div>
        </div>
    </div>
        <!-- QUESTA SEZIONE IN BASSO SERVE SOLO PER OTTIMIZZARE E ALLEGERIRE IL CODICE. Modifica ed aggiungi fanno la stessa cosa, e potrei far comparire il codice solo quando richiamato tramite pulsante-->
    <div id="Option">
    </div>
</div>

<p id="prova"></p>

<!--  End HTML Area ================================================================================================================================================================ -->

<?php
CloseCon($conn);
?>

<!--  Script Area ================================================================================================================================================================ -->
<script>
    let ul = document.querySelector(".ul");
    let prev = document.querySelector(".prev");
    let next = document.querySelector(".next");
    let current_page = <?php echo (int)$page; ?>;
    let active_page = "";

    let total_page = <?php echo (int)$column; ?>; // qua potrei inserire un valore PHP che cambia in base alla query fatta

    create_pages(current_page); // mancava la chiamata iniziale per far sì che vengano generate almeno le prime pagine

    function create_pages(current_page)
    {
        ul.innerHTML="";
        document.getElementById("currentPage").value = current_page;

        let before_page = current_page - 2;
        let after_page = current_page + 2;

        if(current_page == 2)
        {
            before_page = current_page - 1;
        }
        if(current_page == 1)
        {
            before_page = current_page;
        }

        if(current_page == total_page - 1)
        {
            after_page = current_page + 1;
        }
        if(current_page == total_page)
        {
            after_page = current_page;
        }

        for(let i = before_page; i <= after_page; i++)
        {
            if(current_page == i)
            {
                active_page = "active_page";
            }else
            {
                active_page = "";
            }
            ul.innerHTML += `<li onclick="changePage(${i})"><a href="#" class="page_number ${active_page}" onclick="changePage(${i})">${i}</a></li>`;
        }
        // funzione per i pulsanti
        prev.onclick = function ()
        {
            if(current_page > 0)
            {
                changePage(current_page - 1);
            }
            /*
            current_page--;
            create_pages(current_page);
            */
        }
        next.onclick = function ()
        {
            if(current_page < total_page)
            {
                changePage(current_page + 1);
            }
            /*
            current_page++;
            create_pages(current_page);
            */
        }
        //================================ QUESTO è SOLO PER DISPLAY
        if(current_page <= 1)
        {
            prev.style.display = "none";
        }else
        {
            prev.style.display = "block";
        }
        
        if(current_page >= total_page)
        {
            next.style.display = "none";
        }else
        {
            next.style.display = "block";
        }
    }

    function changePage(page)
    {
        if(page < 1 || page > total_page || page === current_page)
        {
            return;
        }

        current_page = page; // aggiorno la pagina corrente
        create_pages(current_page); // ricreo la paginazione
        document.getElementById("offset").submit(); // invia il form
    }
/*
    function Modifica()
    {
        document.getElementById("Option").innerHTML=
        `<br/><br/>
            <p id="messagehelp">I dati sono stati inseriti correttamente</p>
            <div class = "addForm" id="addForm">
                    <form action="functions/modify.php" method="GET">
                        Nome: <input type="text" id="name"><br/>
                        Cognome: <input type="text" id="surname"><br/>
                        E-Mail: <input type="text" id="email"><br/>
                        Password: <input type="text" id="password"><br/>
                        <input type="hidden" id="add" value="">
                        <button type="submit">modifica</button>
                    </form>
                <button type="button" onclick="Back()">Indietro</button>
            </div>`;
    }
    function Back()
    {
        document.getElementById("Option").innerHTML = '';
    }
        */
    function modify(mail)
    {
        document.getElementById("mail").value = mail;
        var x = document.getElementById("modifyForm");
        if(x.style.display == "none")
        {
            x.style.display = "block";
        }else
        {
            x.style.display = "none";
        }
    }

    function ShowM()
    {
        var x = document.getElementById("modifyForm");
        if(x.style.display == "none")
        {
            x.style.display = "block";
        }else
        {
            x.style.display = "none";
        }
    }

    function Show()
        {
            var x = document.getElementById("addForm");
            if(x.style.display == "none")
            {
                x.style.display = "block";
            }else
            {
                x.style.display = "none";
            }
            document.getElementById("messagehelp").style.display = "none";
        }

    function Search(word)
    {

        if(word.length != 0)
        {
            http = new XMLHttpRequest();
            http.onload = function()
            {
                // istruzioni che servono per cercare parole
                // inoltre sistemare la tabella in accordo con l'output "sugerito";
                var r = JSON.parse(this.responseText);
                document.getElementById("dataTable").innerHTML = '';

                for(let i = 0; i < r.length; i++)
                {
                    var name = r[i].name;
                    var surname = r[i].surname;
                    var email = r[i].email;
                    var password = r[i].password;

                    document.getElementById("dataTable").innerHTML +=
                    `<tr>
                        <td><b>${email}</td>
                        <td><i>${name}</td>
                        <td>${surname}</td>
                        <td>${password}</td>
                        <td>${r[i].datainizio}</td>
                        <td>${r[i].datafine}</td>
                        <td class="btn">
                            <form action="functions/modify.php" method="GET">
                                <input type="hidden" value="${email}" name="email">
                                <button class="modify" type="submit" onclick="location.href" style="">Modifica</button>
                            </form>
                        </td>
                        <td class="btn">
                            <form action="functions/deleteData.php" method="GET">
                                <input type="hidden" value="${email}" name="email">
                                <button class="delete" type="submit" onclick="location.href;"><b>Elimina</b></button>
                            </form>
                        </td>
                    </tr>`;
                }
                // Qui recupero TUTTE LE INFORMAZIONI che prendiamo tramite JS o altre fonti
            }

            http.open("GET", "functions/advancedSearch.php");
            http.setRequestHeader("keyWord", word);
            http.send();
        }else{
            location.href;
        }
    }
</script>
<!--  End Script Area ================================================================================================================================================================ -->


<!--  Style Area ================================================================================================================================================================ -->

<style>
    table{
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 10px 30px -15px #000;
    }
    .addForm{
        display: none;
    }
    .modifyForm
    {
        display: none;
    }
    #messagehelp{
        display: none;
    }
    table,th,td{
        border: 2px solid;
    }
    th{
        background-color: gray;
        color: white;
        border-color: black;
    }
    button.modify{
        background-color: yellow;
        display: block;
        margin: auto;
        padding: 5px 20px;
    }
    button.delete{
        background-color: red;
        display: block;
        margin: auto;
        padding: 5px 20px;
    }
    button.add{
        background-color: green;
        color: white;
        padding: 5px 20px;
    }
    td.searchTitle{
        color:gray;
    }
    div.Table{
        border: 2px solid;
    }
    td.btn{
        border: none,
    }
    th button{
        background-color:gray;
        color: white;
        border: none;
        width:100%;
        float: left;
        min-height:100%;
    }
    ol{
        align: center;
    }
    /*          Questa è la sezione in cui creo la paginazione           */
    .box{
        background-color: white;
        padding: 10px;
        border-radius: 100px;
        box-shadow: 0px 10px 30px -15px #000;
        display: flex;
        align-items: center;
    }
    .box ul{
        display: flex;
        margin: 0px 10px;
    }
    .box ul li{
        list-style: none;
        margin: 0px 5px;
        width: 40px;
        height: 20px;
        line-height: 20px;
        border-radius: 100px;
        text-align: center;
    }
    .box ul li a{
        font-size: 25px;
        text-decoration: none;
        color: #000;
        display: block;
        border-radius: 50px;
        transition: 0.2s;
    }
    .box ul li .active_page{
        background-color: orange;
        color: white;
    }
    .box ul li a:hover,
    .box button a:hover{
        background-color: orange;
        color: white;
    }
    /*bottoni*/
    .box button{
        font-size: 10px;
        font-weight: bold;
        background-color: #f1f1f1;
        border: none;
        cursor: pointer;
        border-radius: 50px;
        overflow: hidden;
    }
    .box button a{
        text-decoration: none;
        padding: 5px 10px;
        display: block;
        color: #000;
        transition: 0.2s;
    }
</style>
<!--  End Style Area ================================================================================================================================================================ -->
