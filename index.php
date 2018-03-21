<?php
	//include("session.php");
	$local_ip = getenv('REMOTE_ADDR');
?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
<script>
	$.get("http://ipinfo.io", function (response) {
		$("#ip").html("IP: " + response.ip);
		$("#address").html("Location: " + response.city + ", " + response.region);
		$("#details").html(JSON.stringify(response, null, 4));
	}, "jsonp");
</script>
<?php
	$remote_ip = "<div id='ip'></div>";
	$location = "<div id='address'></div>";
	$location_details = "<pre id='details'></pre>";
	$curdatetime     = date("Y-m-d h:i:sa");

    error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
    ini_set("display_errors", 1);
	
	
	
	// Use Connect Script
   include("connect.php");

    session_start(); // Starting Session
    if(isset($_SESSION['login_user'])){
        $session_webmail = $_SESSION['login_user'];
        $issuchuser = mysqli_query($db,"SELECT * FROM user WHERE username = '$session_webmail'");
        $passwordlogin = mysqli_num_rows($issuchuser);
        $issuchacaduser = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$session_webmail'");
        $passwordloginacad = mysqli_num_rows($issuchacaduser);
        
        if ($passwordlogin == 1) {
            header("location: admin/system.php");
            }
        else if ($passwordloginacad == 1){
              header("location: acad_admin/system.php");
            }
        else{
             header("location: system.php");
            }
        }
	
	
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
	$ipaddress = 'UNKNOWN';

	$error=''; // Variable To Store Error Message
	
	// Check if username and password where submitted
	if (isset($_POST['Submit'])) {
	if (empty($_POST['user']) || empty($_POST['pass'])) {
		$error = "Enter both Username and Password";
	}
	else
	{
	  
	  // Variables that data come from the form
      $username = $_POST["user"];
      $password = $_POST["pass"];
	  $mailserver = $_POST['mailserver'];

      // Check if username and password where submitted
      //if (!$username) {
      //    echo "<center><b>Please Enter Your Username <br><br><a href='index.php'>Back</a>"; exit;
      //}
      //if (!$password) {
      //    echo "<center><b>Please Enter Your Password <br><br><a href='index.php'>Back</a>"; exit;
      //}
	
      // Use Connect Script
      include("connect.php");
	
	  // To protect MySQL injection for Security purpose
	  $username = stripslashes($username);
	  $password = stripslashes($password);
	  $username = mysqli_real_escape_string($db,$username);
	  $password = mysqli_real_escape_string($db,$password);
	  
      // MD5 Username and Password
      //$username = MD5($username);
     //$password = MD5($password);
	
	  // Check if useris Admin.
      $isusernameadmin = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
      $usernameloginadmin = mysqli_num_rows($isusernameadmin);
		  // Check if useris acad_Admin.
      $isusernameacadadmin = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$username'");
      $usernameloginacadadmin = mysqli_num_rows($isusernameacadadmin);  
      // Check if username exists. If not then say no such username.
      //$issuchusername = mysql_query("SELECT * FROM cls_users WHERE username = '$username'");
      //$usernamelogin = mysql_num_rows($issuchusername);
	  
	  //IF User is Admin
	  if ($usernameloginadmin == 1) {

          $issuchpassword = mysqli_query($db,"SELECT * FROM user WHERE username = '$username' AND password = '$password'");
          $passwordlogin = mysqli_num_rows($issuchpassword);
		  
		  // If password is correct
          if ($passwordlogin == 1) {
			  
              $time = time();
			  $_SESSION['login_user']=$username; // Initializing Session
			  
			  // Get details of user from Database and put them in variables
			  $query = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
                          $row = mysqli_fetch_assoc($query);
                          $name = $row[2];
			 // $name= mysql_result($query,0,2);
			  $current_location_1 = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
                          $row_1 = mysqli_fetch_row($current_location_1);
	                 // $current_location = mysql_result($current_location_1,0,6);
			  $current_location = $row_1[6];
			  // Check user if he/she is a new user
			  $result = mysqli_query($db,"SELECT id FROM user_activity WHERE webmail = '$username'");
			  if(mysqli_num_rows($result) == 0) {
				  $sql=mysqli_query($db,"UPDATE user SET localip='$ipaddress' WHERE username='$username'");
				  mysqli_query($db,"INSERT INTO user_activity VALUES ('','$username','$name','$current_location','Logged In','private','$curdatetime')");
				  header('Location: admin/system_change_password.php'); // Redirecting To password changing page
			  } else {
				  $sql=mysqli_query($db,"UPDATE user SET localip='$ipaddress' WHERE username='$username'");
				  mysqli_query($db,"INSERT INTO user_activity VALUES ('','$username','$name','$current_location','Logged In','private','$curdatetime')");
				  header("Location:" . $_SESSION['after_login']);
				  //header('Location: admin/system.php'); // Redirecting To system.php page
			  }
          }
          else {
              $error = "Incorrect Username/Password <br></br>";
          }
      }
      //IF User is acad_Admin
      else if($usernameloginacadadmin == 1) {

          $issuchacadpassword = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$username' AND password = '$password'");
          $acadpasswordlogin = mysqli_num_rows($issuchacadpassword);
		  
		  // If password is correct
          if ($acadpasswordlogin == 1) {
			  
              $time = time();
			  $_SESSION['login_user']=$username; // Initializing Session
			  
			  // Get details of user from Database and put them in variables
			  $query = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$username'");
                          $row = mysqli_fetch_assoc($query);
                          $name = $row[2];
			 // $name= mysql_result($query,0,2);
			  $current_location_1 = mysqli_query($db,"SELECT * FROM acad_user WHERE username = '$username'");
                          $row_1 = mysqli_fetch_row($current_location_1);
	                 // $current_location = mysql_result($current_location_1,0,6);
			  $current_location = $row_1[6];
			  // Check user if he/she is a new user
			  $result = mysqli_query($db,"SELECT id FROM user_activity WHERE webmail = '$username'");
			  if(mysqli_num_rows($result) == 0) {
				  $sql=mysqli_query($db,"UPDATE acad_user SET localip='$ipaddress' WHERE username='$username'");
				  mysqli_query($db,"INSERT INTO user_activity VALUES ('','$username','$name','$current_location','Logged In','private','$curdatetime')");
				  header('Location: acad_admin/system_change_password.php'); // Redirecting To password changing page
			  } else {
				  $sql=mysqli_query($db,"UPDATE acad_user SET localip='$ipaddress' WHERE username='$username'");
				  mysqli_query($db,"INSERT INTO user_activity VALUES ('','$username','$name','$current_location','Logged In','private','$curdatetime')");
				//  header("Location:" . $_SESSION['after_login']);
				  header('Location: acad_admin/system.php'); // Redirecting To system.php page
			  }
          }
          else {
              $error = "Incorrect Username/Password <br></br>";
          }
      }

      // If username exists as normal user
		else{
			//include the config file
			include_once('config.php');
			
			//Check if the login credentials provided are valid
			if( $iitgAppUser->login($username, $password, $mailserver) )
			{
				//the login credentials provided are valid
				$time = time();
				$_SESSION['login_user'] = $username; // Initializing Session
				include("connect.php");
				$id = $_SESSION['login_user'];
				$query = "SELECT * FROM studentinfo WHERE webmail = '$id'";
				$result = mysqli_query($db,$query);
				//if (mysql_num_rows($result)==0) {
				//	mysql_query("INSERT INTO studentinfo VALUES ('','','','','','$id','','','','','','','','','','','','','','','','','','','','','','','','')");
				//}
				header("Location:" . $_SESSION['after_login']);
				//header('Location: system.php'); // Redirecting To system.php page
				exit;
			}
			else
			{
				//the login credentials provided are invalid
				$error = "Incorrect Username/Password <br></br>";
			}
		}
	}
	}
  // End if no cookie present

?>
<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
	
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading" style="text-align:center">
							<img src="images/logo.png" width="30%"><br></br>
                            <h3 class="panel-title centre">IIT Guwahati - Central Login System</h3>
                        </div>
						<div style="color:red;text-align: center;padding-top: 10px;margin-bottom: -10px;">
							<?php echo $error ?>
						</div>
                        <div class="panel-body">
                            <form role="form" name="form1" action="" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Webmail ID" name="user" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                                    </div>
									<div class="form-group">
										<select name="mailserver" id="mailserver" class="form-control" placeholder="Login Server" tabindex="1" required>
											<option value='202.141.80.12' selected>Teesta</option>
											<option value='202.141.80.9'>Naambor</option>
											<option value='202.141.80.10'>Disang</option>
											<option value='202.141.80.11'>Tamdil</option>
											<option value='202.141.80.13'>Dikrong</option>
										</select>
									</div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
											
                                        </label>
                                    </div>
                                    <button type="submit" name="Submit" class="btn btn-default">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
					<p style="text-align:center;">Developed by Ravi Nishant<br><b>SWC, IIT Guwahati</b></p>
                </div>
            </div>
        </div>

        <?php include("scripts.php"); ?>

    </body>
</html>
