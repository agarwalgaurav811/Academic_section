<?php
error_reporting(1);
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysql_connect("localhost", "root", "gaurav");//originalpassword :root
// Selecting Database
$db = mysql_select_db("saDb", $connection);
session_start();// Starting Session

// Storing Session
$user_check = $_SESSION['login_user'];

// SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("select * from studentinfo where webmail='$user_check'", $connection);
$row = mysql_fetch_assoc($ses_sql);
//$login_session =$row['webmail'];
$login_session = $_SESSION['login_user'];
$rollno = $row['studentId'];
$name = $row['name'];
$user_phone = $row['cellNo'];
$user_gender = $row['gender'];
$user_hostel = $row['hostel'];
$user_room = $row['room_no'];
$user_image = $row['pic'];
$current_dept = $row['department'];
$currentdatetime = mysql_query('select now()');
$curdatetime     = mysql_result($currentdatetime, 0);

//Variable Current Year
$curYear = date('Y'); 

if(!isset($login_session)){
	mysql_close($connection); // Closing Connection
	$_SESSION['after_login'] = $_SERVER['REQUEST_URI'];
	header('Location: index.php'); // Redirecting To Home Page
}
if(isset($_SESSION['login_user'])){
	$session_webmail = $_SESSION['login_user'];
	$issuchuser = mysql_query("SELECT * FROM user WHERE username = '$session_webmail'");
    $passwordlogin = mysql_num_rows($issuchuser);
        $issuchacaduser = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$session_webmail'");
    $acadpasswordlogin = mysqli_num_rows($issuchacaduser);
	if ($passwordlogin == 1) {
		header("location: admin/system.php");
	}
        else if($acadpasswordlogin == 1){
               header("location: acad_admin/system.php");
       }
}
?>
