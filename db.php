<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "my_mynotaspese";

$db = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Connessione fallita");
mysql_select_db($mysql_database, $db) or die("Connessione fallita");
?>