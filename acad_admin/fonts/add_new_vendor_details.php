<?php
	include("session.php");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	ini_set("display_errors", 1);

	include("connect.php");
	
	$vendor_name = $_POST['name'];
	$buisness_type = $_POST['btype'];
	$pdf=$_FILES['pdf']['name'];

	//$currentdatetime = mysql_query('select now()');
	//$curdatetime = mysql_result($currentdatetime,0);
	//$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
	//$curdatetime = $date->format('d-m-Y H:i:s');
	$time_d = date("d");
	$time_m = date("M");
	$time_y = date("Y");
	$target_dir = "uploads/";
	$target_file_pdf = $target_dir.$_FILES['pdf']['name'];
	$uploadfile = $target_dir . basename($_FILES['pdf']['name']);

		


	if (isset($_POST['Submit'])) {
		if ($vendor_name == ''){
			$error = "<font color='red'>All fields are required.";
		}
		else if($buisness_type == ''){
			$error = "All fields are required.";
		}
		else if($pdf == ''){
			$error = "Please uplaod file in Pdf format.";
		}
		else{
			echo $uploadfile;
			$success = "Successfully Updated!";
			$row_query = $dbh->query("SELECT * FROM vendor_details");
			$row_count = mysqli_num_rows($row_query);
			$row_count = $row_count +1;
			
					        
			$cur_query = "INSERT INTO 'vendor_details' VALUES ($row_count,'$vendor_name','$buisness_type','$pdf')";
			$dbh->query("INSERT INTO vendor_details VALUES ($row_count,'$vendor_name','$buisness_type','$pdf')");
			move_uploaded_file($_FILES['pdf']['tmp_name'],$uploadfile);

		}
	}
?>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Update Vendor Details
                            </div>
                            <div class="panel-body">
								<?php
									if($error != ''){
									?>
									  <div class="alert alert-warning">
										<?php if(isset($error)) { echo $error; }  ?>
									  </div>
									<?php
									}
									else if($success != ''){  
									?>
									  <div class="alert alert-success">
										<?php if(isset($success)) {											
											echo $success;
											echo "<br/>";
											echo $row_count;
											echo "<br/>";
											echo $cur_query;
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
                                        <form name="form2" method="POST" class="col s12" action="" enctype="multipart/form-data">
                                            <div class="form-group col-md-6">
                                                <label>Name of Vendor</label>
                                                <input class="form-control" name="name" >
                                            </div>
					    <div class="form-group col-md-6">
                                                <label>Business Type</label>
                                                <input class="form-control" name="btype" >
                                            </div>
					    <!--<div class="form-group col-md-12">
                                                <label>Vendor Profile Form</label>
                                                <input class="form-control" name="file" >
                                            </div>   -->
					   </div>
					   <div class="form-group col-md-6 pdf">
                                                <label>Vendor Profile Form</label>
                                                <input class="form-control" type="file" name="pdf">
                                            </div>
											<div class="form-group col-md-12">
												<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
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
