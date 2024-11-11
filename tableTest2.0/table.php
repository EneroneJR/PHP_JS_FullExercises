<?php
include "functions/test.php";

$conn = OpenCon();

$_SESSION["KeyWord"] = '';

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
                <td><input style="width:100%" type="date" id="startDate" value="1800-01-01"placeholder = "Search Start Date"></td>
                <td><input style="width:100%" type="date" id="endDate" value="this.date" placeholder = "Search End Date"></td>
                <td><input style="width:100%" type="text" id="emailKey" placeholder="Search E-Mail"></td>
                <td><input style="width:100%" type="text" id="nameKey" placeholder="Search Name"></td>
                <td><input style="width:100%" type="text" id="surnameKey" placeholder="Search Surname"></td>
                <!--<td><input type="text" id="passwordKey"></td> è inutile -->
                <td><button onclick="Ricerca()" style="width:100%">Go</button></td>
            </tr>
            <tr>
                <th><button onclick="Conferma()">Email</button></th>
                <th><button onclick="Conferma()">Nome</button></th>
                <th><button onclick="Conferma()">Cognome</button></th>
                <th><button onclick="Conferma()">Password</button></th>
                <th><button onclick="Conferma()">Data Inizio</button></th>
                <th><button onclick="Conferma()">Data Fine</button></th>
                <td colspan="2"><input style="width:100%;" type="text" placeholder="Generic Dynamic Search" onkeyup="Search(this.value)"></td>
                <!--<th><button onclick="Conferma()">Search bar:</button></th>
                <th><input type="text" placeholder="Search" onkeyup="Search(this.value)"></th>-->
            </tr>
        </thead>
        <tbody id="dataTable">
        </tbody>
            <tr>
                <td class = "btn">
                    <button class="add" onclick="">Aggiungi</button>
                    <!-- Attualmente non funziona, da sistemare dopo -->
                </td>
                <td colspan="5" class="btn">
                    <div class="box">
                    <button type="button"><a href="#">«</a></button>
                    <ul>
                        <li><a href="#" class="page_number">1</a></li>
                        <li><a href="#" class="page_number">2</a></li>
                        <li><a href="#" class="page_number">3</a></li>
                    </ul>
                    <button type="button"><a href="#">»</a></button>
                    </div>
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
                        <select name="rowNumber" id="rowNumber" onchange="changeWidth()">
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </td>
            </tr>
    </table>
</div>

<p id="prova"></p>

<!--  End HTML Area ================================================================================================================================================================ -->
<!--  Script Area ================================================================================================================================================================ -->

<script>
    var rowNumber = '3';

    function changeWidth()
    {
        rowNumber = document.getElementById("rowNumber").value;
        document.getElementById("prova").innerHTML = rowNumber;
    }
    
    function Conferma()
    {
        document.getElementById("prova").innerHTML = "Funziona";
    }
    window.onload = function()
    {
        
        const http = new XMLHttpRequest();
        document.getElementById("endDate").valueAsDate = new Date();

        http.onload = function()
        {
            var r = JSON.parse(this.responseText);

            for(let i = 0; i < r.length; i++)
            {
                var name = r[i].name;
                var surname = r[i].surname;
                var email = r[i].email;
                var password = r[i].password;
                var startdate = r[i].datainizio;
                var endDate = r[i].datafine

                document.getElementById("dataTable").innerHTML +=
                `<tr>
                    <td><b>${email}</td>
                    <td><i>${name}</td>
                    <td>${surname}</td>
                    <td>${password}</td>
                    <td>${startdate}</td>
                    <td>${endDate}</td>
                    <td class="btn">
                        <form action="functions/newstuff" method="GET">
                            <input type="hidden" value="${email}" name="email">
                            <button class="modify" type="submit" style="">Modifica</button>
                        </form>
                    </td>
                    <td class="btn">
                        <form action="functions/newstuff" method="GET">
                            <input type="hidden" value="${email}" name="email">
                            <button class="delete" type="submit"><b>Elimina</b></button>
                        </form>
                    </td>
                </tr>`;
            }
        }

        http.open("GET", "../oldDemoTest/newtablepage/sendata.php");
        http.send();
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

    function Ricerca()
    {
        var email = document.getElementById("emailKey").value;
        var name = document.getElementById("nameKey").value;
        var surname = document.getElementById("surnameKey").value;
        var startdate = new Date(document.getElementById("startDate").value);
        var endate = new Date(document.getElementById("endDate").value);

        var str = startdate.toDateString();
        var end = endate.toDateString();


        http = new XMLHttpRequest();
        http.onload = function()
        {}
        http.open("GET", "functions/search.php");
        http.setRequestHeader("mail", email);
        http.setRequestHeader("name", name);
        http.setRequestHeader("surname", surname);
        http.setRequestHeader("sdate", str);
        http.setRequestHeader("edate", end);
        http.send();
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
    }
    button.delete{
        background-color: red;
        display: block;
        margin: auto;
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
<!--  PHP Coding Area ================================================================================================================================================================ -->
<?php


CloseCon($conn);
?>