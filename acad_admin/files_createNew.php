<?php
	include("session.php");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	ini_set("display_errors", 0);

	include("connect.php");
	
	
	//Getting maximum Application ID
	//$rowSQL = mysql_query( "SELECT MAX(id) AS max FROM `files`;" );
	//$row_maxid = mysql_fetch_array( $rowSQL );
	//$largestID = $row_maxid['max'];
	//$newID = $largestID + 1;
	$min_range=10000;
	$max_range=99999;
	$newID = rand($min_range,$max_range);
	
	//IP Tracking
	//End of IP Tracking
	
	if (!isset($_POST['Submit'])) {
		$fapp             = $current_dept.'/'.$curYear.'/'.$newID;
	}
	$fno             = $_POST['fileno'];
	$fdate           = $_POST['filedate'];
	$fname           = $_POST['filename'];
	$fwebmail 		 = $_POST['applicant_webmail'];
	$faddress        = $_POST['fileaddress'];
	$fdesc           = $_POST['filedesc'];
	$fdeal           = $_POST['filedeal'];
	$initiator       = $name;
	$user_activity   = "New entry created with Application No. ".$fno;
	$currentdatetime = mysqli_query($db,'select now()');
        $row = mysqli_fetch_assoc($currentdatetime);
        $curdatetime     = $row;
	//$curdatetime     = mysqli_result($currentdatetime, 0);
	$curYear         = date('Y');
	$error = "";
	$success = "";
	//$rowSQL = mysql_query( "SELECT MAX( fileno ) AS max FROM `files`;" );
	//$row_highest = mysql_fetch_array( $rowSQL );
	//$largestFileNo = $row_highest['max'];
	//echo "Largest Form No:";
	//echo $largestFileNo;
	$idindb          = mysqli_query($db,"SELECT * FROM acad_files where fileno = '$fno' ");
	$isidindb        = mysqli_num_rows($idindb);
	$idindb2   = mysqli_query($db,"SELECT * FROM acad_files where id = '$newID' ");
	$isidindb2 = mysqli_num_rows($idindb2);
	//echo"$isidindb";
	if (isset($_POST['Submit'])) {
		if ($fdate == '' OR $fname == '' OR $faddress == '' OR $fdeal == '' OR $fdesc == '') {
			$error = "<font color='red'>Input all fields to create a new entry.</font>";
		}
		else if (strpos($fwebmail, 'iitg') !== false) {
			$error = "<font color='red'>Webmail format is invalid; don't include @iitg.ernet.in/iitg.ac.in</font>";
		}else if (preg_match('/@/', $fwebmail)){
			$error = "<font color='red'>Entered webmail contains @</font>";
		}else if ($isidindb2 == 1) {
			$error = "Application <b>$fno</b> <font color='red'> is already in the database.</font>";
		}
		//else if ($isidindb2 == 1){
		//echo "File [ <b>$fname</b> ]<font color='red'> is already in the database";
		//}
		else {
			$insert = mysqli_query($db,"INSERT INTO `acad_files` VALUES ('$newID','$fno','$fname','$fwebmail','$fdate','$faddress','$fdesc','$fdeal','$current_location','$curdatetime','$fdeal','','$current_location','$name','Under Process')");
			if($insert){
				$success = "<font color='green'>Application No. <b>$fno</b> is successfully saved into database with the following details.</font>";
				mysqli_query($db,"INSERT INTO movement VALUES ('','$fno','$fname','$fdate','$fdesc','$current_location','$fdeal','$fdeal','Application Received','Under Process','$initiator','$curdatetime')");
				mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','$user_activity','public','$curdatetime')");
				mysqli_query($db,"INSERT INTO hits VALUES ('','$fno','$current_location')");
				$message = "Dear ".$fname."\r\n Your application has been successfully submitted to SA Office. \r\n Application No. ".$fno." \r\n Subject: ".$fdesc." \r\n You can track your application via CLS.\r\n Thanking You.\r\n Regards,\r\n Team SWC";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: SWC, IIT Guwahati <swc@iitg.ernet.in>' . "\r\n";
				//$headers .= 'Cc: swc@iitg.ernet.in, saoff@iitg.ernet.in, hossa@iitg.ernet.in' . "\r\n";
				$headers .= 'Cc: swc@iitg.ernet.in'. "\r\n";
				$user_webmail = $fwebmail."@iitg.ernet.in";
				$subject = 'Application No. '.$fno.' submission confirmation';
				mail($user_webmail , $subject , $message , $headers);
			}else{
				$error = "Something went wrong!";
			}
		}
	}
?>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<script>
			  $( function() {
				$( "#datepicker" ).datepicker({maxDate: "0D",dateFormat: "dd/mm/yy",showAnim: "slideDown" });
			  } );
			  $(function(){
				  $('#webmail').keypress(function(e){
					if(e.which == 64 || e.which == 34 || e.which == 39){
						return false;
					} else {
					  return true;
					}
				  });
				});
			</script>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Create New Entry
                            </div>
                            <div class="panel-body">
								<?php 
									if($error != ''){
									?>
									  <div class="alert alert-warning">
										<?php if(isset($error)) { echo $error; }?>
									  </div>
									<?php
									}
									else if($success != ''){
									?>
									  <div class="alert alert-success">
										<?php if(isset($success)) {											
											echo $success;
										?>
										<style>
											.ongoing{
												display: none;
											}
										</style>
										<?php
										} 
										?>
									  </div>
									<?php
									}
									else{
										//echo "";
									}
								?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" name="form1" method="POST" action="">
                                            <div class="form-group col-md-6">
                                                <label>Application Number</label>
                                                <input class="form-control" name="fileno" value="<?php if($success != ''){echo $fno; } else{echo $fapp;} ?>" autocomplete="off" readonly>
											</div>
											<div class="form-group col-md-6">
                                                <label>Application Date</label>
												<input id="datepicker" class="form-control" type="text" placeholder="DD/MM/YYYY" name="filedate" value="<?php echo $fdate; ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Applicant</label>
                                                <input class="form-control" type="text" name="filename" value="<?php echo $fname; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Applicant Webmail (optional)</label>
                                                <input id="webmail" class="form-control" type="text" name="applicant_webmail" placeholder="Don't include @iitg.ernet.in/iitg.ac.in" value="<?php echo $fwebmail; ?>">
                                            </div>
											<div class="form-group col-md-6">
                                                <label>Addressed To</label>
                                                <input class="form-control" type="text" name="fileaddress" value="<?php echo $faddress; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Application Description</label>
                                                <input class="form-control" rows="3" type="text" value="<?php echo $fdesc; ?>" name="filedesc" autocomplete="off">
                                            </div>
											<?php
											if($success != '' && isset($fdeal)) { 
												?>
													<div class="form-group col-md-6">
														<label>Dealing Person</label>
														<input class="form-control" type="text" name="filedeal" value="<?php echo $fdeal; ?>">
													</div>
													<div class="form-group col-lg-12">
														<a href='system_update_application.php?edit=<?php echo $fno; ?>'><button type="button" class="btn btn-default">Edit</button></a>
														<a href='system_track_application.php?track=<?php echo $fno; ?>'><button type="button" class="btn btn-default">Track</button></a>
													</div>
												<?php
											}
											else{
											?>
											<div class="form-group col-md-6">
                                                <label>Dealing Person</label>
                                                <select class="form-control" name="filedeal">
                                                <?php
													$query  = "SELECT * FROM acad_user WHERE department = $current_dept";
													$result = mysqli_query($db,$query);
													echo "<option disabled selected> Dealing Person </option>";
													while ($row = mysqli_fetch_array($result)) {
														$file = $row[2];
														echo "<option>$file</option>";
													}
												?>
                                                </select>
                                            </div>
											<?php
											} 
											?>
											<div class="form-group col-md-12">
												<button type="submit" name="Submit" class="btn btn-default ongoing">Submit</button>
												<button type="reset" class="btn btn-default ongoing">Reset</button>
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
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
