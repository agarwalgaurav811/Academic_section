<?php

/***************************************************************************
 *                         Connect to MySQL Server                         *
 ***************************************************************************/

$db=mysqli_connect ("localhost", "root", "gaurav","saDb") or die ('I cannot connect to the database because: ' . mysql_error());
#mysql_select_db ("saDb");
//die;
/////// Update database login details here /////
$hab_dbhost_name = "localhost"; // host name 
$hab_database = "saDb";       // database name
$hab_username = "root";            // login userid 
$hab_password = "gaurav";            // password 
//////// End of database details of server //////

									
?>
