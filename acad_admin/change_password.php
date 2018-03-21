<?php 
	include("session.php");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	ini_set("display_errors", 0);

	include("connect.php");
	$error = "";
	$success = "";
	
	// For Password Change
	$new_pass  			 = $_POST['new_pass'];
	$confirm_new_pass	 = $_POST['confirm_new_pass'];
	
	if (isset($_POST['SubmitPassword'])) {
		if($new_pass == '' OR $confirm_new_pass == ''){
			$error = "Enter all fields.";
		}
		else if($new_pass != $confirm_new_pass){
			$error = "Confirm password is not same as New Password.";
		}
		else{
			mysqli_query ($db,"UPDATE acad_user SET password ='$new_pass' WHERE username = '$login_session'");
			mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','Password Changed','private','$curdatetime')");
			$success = "Password successfully changed! Thank You.";
		}
	}
?>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Choose New Password
                            </div>
							<div class="panel-body">
								<?php 
									if($error != ''){
									?>
									  <div class="alert alert-warning" style="color:red">
										<?php if(isset($error)) { echo $error; }?>
									  </div>
									<?php
									} else if($success != ''){
									?>
									  <div class="alert alert-success" style="color:green">
										<?php if(isset($success)) { echo $success; }?>
									  </div>
									<?php
									}
								?>
								<div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" name="form1" method="POST" action="">
                                            <div class="form-group col-md-6 col-md-offset-3">
												<label>New Password</label>
												<input class="form-control" type="password" name="new_pass">
											</div>
											<div class="form-group col-md-6 col-md-offset-3">
												<label>Confirm New Password</label>
												<input class="form-control" type="password" name="confirm_new_pass">
											</div>
											<div class="form-group col-md-6 col-md-offset-3">
												<button type="submit" name="SubmitPassword" class="btn btn-primary">Submit</button>
											</div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
							</div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /#page-wrapper -->
 
