<?php
$user = "root";
$pass = "";
$db = "mydb";
$db = new mysqli("localhost",$user,$pass,$db) or die("Unsucessfull");//skips the rest script in case db is not connected
$sql = "CREATE TABLE IF NOT EXISTS mydiary(name TEXT, email TEXT, password TEXT, entry TEXT)";

?>
