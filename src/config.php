<?php
if(!defined('host')) define('host', 'dijkstra.ug.bcc.bilkent.edu.tr');
if(!defined('dbname')) define('dbname', 'ufuk_palpas');
if(!defined('username')) define('username', 'ufuk.palpas');
if(!defined('password')) define('password', 'RYFTwiPs');
$mysqli = mysqli_connect(host, username, password, dbname);
if($mysqli === FALSE) {
    die("Connection Failed to MySQL. Error: " . mysqli_connect_error());
}
?>