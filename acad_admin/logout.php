<?php
include("session.php");
include("connect.php");
if(session_destroy()) // Destroying All Sessions
{
	mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','Logged Out','private','$curdatetime')");
	header("Location: ../index.php"); // Redirecting To Home Page
}
?>
