<?php

function OpenCon()
 {
    $dbhost = "localhost:3306";
    $dbuser = "oqnotybh_ADMIN";
    $dbpass = "M@lcolmx2817";
    $db = "oqnotybh_mnl_master_db";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    
    return $conn;
 }
 
function CloseCon($conn)
 {
    $conn -> close();
 }
?>