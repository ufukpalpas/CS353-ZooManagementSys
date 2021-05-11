<?php
if(!defined('host')) define('host', 'dijkstra.ug.bcc.bilkent.edu.tr');
if(!defined('dbname')) define('dbname', 'asya_ozer');
if(!defined('username')) define('username', 'asya.ozer');
if(!defined('password')) define('password', 'YdsjunAB');
$mysqli = mysqli_connect(host, username, password, dbname);
if($mysqli === FALSE) {
    die("Connection Failed to MySQL. Error: " . mysqli_connect_error());
}
?>