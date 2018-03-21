<?php
	include("session.php");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	ini_set("display_errors", 1);

	include("connect.php");
	
	$id = $_GET['edit'];
	
	$initiator = $name;
	if($_POST['status'] != ''){
		$fstatus = 'Completed';
	}
	else{
		$fstatus = 'Under Process';
	}
	$fdate           = $_POST['filedate'];
	$fname           = $_POST['filename'];
	$faddress        = $_POST['fileaddress'];
	$fdesc           = $_POST['filedesc'];
	$fcomment        = $_POST['comment'];
	//$fdeal           = $_POST['new_responsible'];
	if($_POST['new_responsible'] != ''){
		$responsible_person  = $_POST['new_responsible'];
	}
	if($_POST['oth_department'] != ''){
		$responsible_dept = $_POST['oth_department'];
		$currentresponsible = $_POST['oth_department'].' '.$_POST['new_responsible'];
	}
	else{
		$responsible_dept = $current_location;
		$currentresponsible = $_POST['new_responsible'];
	}
	$user_activity = "Updated status of Application No. ".$id;
	$currentdatetime = mysqli_query($db,'select now()');
        $curdatetime = mysqli_fetch_array($currentdatetime);
	//$curdatetime     = mysql_result($currentdatetime, 0);
	$curYear         = date('Y');
	$error = "";
	$success = "";
	
	$query_deal = "SELECT * FROM acad_files WHERE fileno = '$id' ";
	$result_deal = mysqli_query($db,$query_deal);
	if (mysqli_num_rows($result_deal)==0) {
		$query_deal = "SELECT * FROM files_jan_june WHERE fileno = '$id' ";
		$result_deal = mysqli_query($db,$query_deal);
		if (mysqli_num_rows($result_deal)==0) {
			$query = "SELECT * FROM old_files WHERE fileno = '$id'";
			$result_deal = mysqli_query($db,$query);
			$row = mysqli_fetch_array($result_deal);
			$fdeal = $row["fdeal"];
			$fwebmail = $row["applicant_webmail"];
		}
		else{
			$query = "SELECT * FROM files_jan_june WHERE fileno = '$id'";
			$result_deal = mysqli_query($db,$query);
			$row = mysqli_fetch_array($result_deal);
			$fdeal = $row["fdeal"];
			$fwebmail = $row["applicant_webmail"];
		}
	}
	else{
		$row = mysqli_fetch_array($result_deal);
		$fdeal = $row["fdeal"];
		$fwebmail = $row["applicant_webmail"];
	}

	if (isset($_POST['Submit'])) {
		if ($fcomment == '' AND $_POST['new_responsible'] == '' AND $_POST['oth_department'] == '' AND $_POST['status'] == '') {
			$error = "<font color='red'>You haven't made any change(s) to update.</font>";
		}
		else {
			$success = "<font color='green'>Application is successfully updated with the following details.</font>";
			mysqli_query($db,"INSERT INTO movement VALUE ('','$id','$fname','$fdate','$fdesc','$current_location','$fdeal','$currentresponsible','$fcomment','$fstatus','$initiator','$curdatetime')");
			mysqli_query ($db,"UPDATE acad_files SET currentloc = '$responsible_dept', status='$fstatus' WHERE fileno = '$id'");
			mysqli_query ($db,"UPDATE old_files SET currentloc = '$responsible_dept', status='$fstatus' WHERE fileno = '$id'");
			mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','$user_activity','public','$curdatetime')");
			$message = "Dear ".$fname."\r\n Your application has been updated by SA Office. \r\n Application No. ".$fno." \r\n Subject: ".$fdesc." \r\n You can track your application via CLS.\r\n Thanking You.\r\n Regards,\r\n Team SWC";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: SWC, IIT Guwahati <swc@iitg.ernet.in>' . "\r\n";
			//$headers .= 'Cc: swc@iitg.ernet.in, saoff@iitg.ernet.in, hossa@iitg.ernet.in' . "\r\n";
			$user_webmail = $fwebmail."@iitg.ernet.in";
			$subject = 'Application No. '.$id.' is updated by SA Office';
			mail($user_webmail , $subject , $message , $headers);
			if($responsible_person != ''){
				mysqli_query ($db,"UPDATE acad_files SET currentresponsible='$responsible_person' WHERE fileno = '$id'");
				mysqli_query ($db,"UPDATE old_files SET currentresponsible='$responsible_person' WHERE fileno = '$id'");
			}
		}
	}
	//$query = "SELECT * FROM files WHERE fileno = '$id' ";
	//$result = mysql_query($query);
	//if (mysql_num_rows($result)==0) {
	//	$query = "SELECT * FROM old_files WHERE fileno = '$id'";
	//	$result = mysql_query($query);
	//}
	//$row = mysql_fetch_array($result);
?>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<!-- Autocomplete Multiple Values -->
			<script src="js/autocomplete.js"></script>
			<script type='text/javascript'>//<![CDATA[
				$(window).load(function(){
					$('#boxid').click(function() {
					  if ($(this).is(':checked')) {
						$(this).siblings('label').html('Completed');
					  } else {
						$(this).siblings('label').html('Under Process');
					  }
					});
				});//]]> 
			</script>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Update Application No. <b><?php echo $row["fileno"]; ?></b>
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
                                                <input class="form-control" name="fileno" value="<?php echo $row["fileno"]; ?>" readonly>
                                            </div>
											<div class="form-group col-md-6">
                                                <label>Application Date</label>
                                                <input class="form-control" type="text" placeholder="DD/MM/YYYY" name="filedate" value="<?php echo $row["fdate"]; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Applicant</label>
                                                <input class="form-control" type="text" name="filename" value="<?php echo $row["filename"]; ?>" readonly>
                                            </div>
											<div class="form-group col-md-6">
                                                <label>Addressed To</label>
                                                <input class="form-control" type="text" name="fileaddress" value="<?php echo $row["faddress"]; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Application Description</label>
                                                <textarea class="form-control" type="text" name="filedesc" readonly><?php echo $row["filedesc"]; ?></textarea>
                                            </div>
											<?php if($row["status"] == 'Completed'){ ?>
												<div class="form-group col-md-6">
													<label>Last Comment</label>
													<textarea class="form-control" type="text" name="comment" readonly>The process of this application is completed.</textarea>
												</div>
											<?php
											} else{ ?>
												<div class="form-group col-md-6">
													<label>Comment (optional)</label>
													<textarea class="form-control" type="text" name="comment"><?php echo $fcomment; ?></textarea>
												</div>
											<?php
											}
											if($success != '') {
												?>
													<div class="form-group col-lg-12" style="padding:0px;">
														<div class="form-group col-md-6">
															<label>Current Responsible Person</label>
															<input class="form-control" type="text" name="new_responsible" value="<?php if($_POST['new_responsible'] != ''){echo $responsible_person;} else{echo $row["currentresponsible"];} ?>">
														</div>
														<div class="form-group col-md-6">
															<label>Current Application Location</label>
															<input class="form-control" type="text" name="oth_department" value="<?php echo $responsible_dept; ?>">
														</div>
														<div class="form-group col-md-6">
															<label>Current Status</label>
															<input class="form-control" type="text" name="status" value="<?php if($row["status"] == "Completed"){echo $row["status"];} else{echo $fstatus;} ?>">
														</div>
													</div>
													<div class="form-group col-lg-12">
														<?php if($fstatus == 'Completed' OR $row["status"] == 'Completed'){ ?>
															<a href='system_update_application.php?edit=<?php echo $id; ?>'><button type="button" class="btn btn-default disabled">Edit</button></a>
														<?php }else{ ?>
															<a href='system_update_application.php?edit=<?php echo $id; ?>'><button type="button" class="btn btn-default">Edit</button></a>
														<?php } ?>
														<a href='system_track_application.php?track=<?php echo $id; ?>'><button type="button" class="btn btn-default">Track</button></a>
													</div>
												<?php
											}
											else if($row["status"] == 'Completed'){
											?>
											<div class="col-lg-12" style="padding:0px;">
												<div class="form-group col-md-6">
													<label>Last Responsible Person</label>
													<input class="form-control" type="text" name="new_responsible" value="<?php echo $row["currentresponsible"]; ?>" readonly>
												</div>
												<div class="form-group col-md-6">
													<label>last Dealing Department</label>
													<input class="form-control" type="text" name="oth_department" value="<?php echo $row["currentloc"]; ?>" readonly>
												</div>
												<div class="form-group col-md-6">
													<label>Current Status</label>
													<input class="form-control" type="text" name="status" value="<?php echo $row["status"]; ?>" readonly>
												</div>
											</div>
											<?php
											}
											else{
											?>
											<div class="col-lg-12" style="padding:0px;">
												<div class="form-group col-md-6">
													<label>Responsible Person (optional)</label>
													<textarea id="new_responsible" class="form-control" type="text" name="new_responsible"></textarea>
												</div>
												<div class="form-group col-md-6">
													<label>Responsible Department/Section (optional)</label>
													<textarea id="oth_department" class="form-control" type="text" name="oth_department"></textarea>
												</div>
											</div>
											<div class="form-group col-md-12">
                                                <div class="checkbox">
													<span><b>Change Status: </b></span>
                                                    <label>
														<input id="boxid" type="checkbox" value="Completed" name="status"><label for="boxid"style="padding-left: 0px;">Under Process</label>
                                                    </label>
                                                </div>
											</div>
											<?php
											} 
											?>
											<?php if($row["status"] != "Completed"){ 
											?>
											<div class="form-group col-md-12">
												<button type="submit" name="Submit" class="btn btn-default ongoing">Update</button>
												<?php if($success == ''){ ?>
													<a href='system_track_application.php?track=<?php echo $id; ?>'><button type="button" class="btn btn-default">Track</button></a>
												<?php } ?>
											</div>
											<?php }
											else{
												if($success == ''){ ?>
													<a href='system_track_application.php?track=<?php echo $id; ?>'><button type="button" class="btn btn-default">Track</button></a>
												<?php }
											}?>
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
