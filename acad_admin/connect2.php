<?php

/***************************************************************************
 *                         Connect to MySQL Server                         *
 ***************************************************************************/

$dbh=mysql_connect ("localhost", "root", "gaurav","saDb") or die ('I cannot connect to the database because: ' . mysql_error());
#mysql_select_db ("saDb");
?>
