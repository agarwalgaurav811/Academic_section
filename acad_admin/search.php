<?php 
	include("session.php"); 
	error_reporting(0);
	
	$error = "";
	$success = "";
	$searchTerm      = $_POST['search_application'];
	$curdatetime     = date("Y-m-d h:i:sa");
	
	$starttime 		 = microtime(true);
	$idindb          = mysqli_query($db,"SELECT * FROM acad_files WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno");
	$idindb1          = mysqli_query($db,"SELECT * FROM old_files WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno");
	$idindb2          = mysqli_query($db,"SELECT * FROM files_jan_june WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno");
	$endtime 		 = microtime(true);
	$duration		 = $endtime - $starttime; //calculates total time taken
	$duration		 = sprintf('%0.5f', $duration);
	$isidindb        = mysqli_num_rows($idindb);
	$isidindb1        = mysqli_num_rows($idindb1);
	$isidindb2        = mysqli_num_rows($idindb2);
	$total_query     = $isidindb + $isidindb1 + $isidindb2;
	if (isset($_POST['Submit'])) {
		if($searchTerm == ""){
			$error = "Enter something...";
		}
		else if ($isidindb == 0 AND $isidindb1 == 0 AND $isidindb2 == 0) {
			$error = "No records found for <b>".$searchTerm."</b> (" .$duration. " seconds).";
			mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','Searched for $searchTerm','public','$curdatetime')");
		}
		else{
			$success = $total_query." records found for <b>".$searchTerm."</b> (" .$duration. " seconds).";
			mysqli_query($db,"INSERT INTO user_activity VALUES ('','$login_session','$name','$current_dept','Searched for $searchTerm','public','$curdatetime')");
		}
	}
?>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Search Application
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
								<div class="row">
                                    <div class="col-lg-6 col-md-offset-3" style="margin-top: 2%;margin-bottom: 2%;">
                                        <form role="form" name="form1" method="POST" action="">
                                            <div class="input-group  custom-search-form">
												<input type="text" class="form-control" name="search_application" placeholder="Enter anything...">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit" name="Submit">
														<i class="fa fa-search"></i> Search
													</button>
												</span>
											</div>
										</form>
										<?php 
											if($error != ''){
											?>
											  <div class="alert alert-warning" style="width:80%;margin-top:5%">
												<?php if(isset($error)) { echo $error; }?>
											  </div>
											<?php
											}
											else if($success != ''){
											?>
											  <div class="alert alert-success" style="width:80%;margin-top:5%">
												<?php if(isset($success)) {											
													echo $success;
												} 
												?>
											  </div>
											<?php
											}
											else{
												//echo "";
											}
										?>
									</div>
								</div>
								<?php if($success != ""){?>
                                <div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="">
										<thead>
											<tr> 
											  <th valign="top" bgcolor="#dedede"> <font>Application No.</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Applicant</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Dealing Person</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Description</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Edit</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Details</font></th>
											</tr>
										</thead>
                                        <tbody>
										<?php 
											include("connect.php");
											$query2 = "SELECT * FROM acad_files WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno";
											$result2 = mysqli_query($db,$query2);
											$query1 = "SELECT * FROM files_jan_june WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno";
											$result1 = mysqli_query($db,$query1);
											$query3 = "SELECT * FROM old_files WHERE (fileno LIKE '%".$searchTerm."%' OR filename LIKE '%".$searchTerm."%' OR applicant_webmail LIKE '%".$searchTerm."%' OR fdate LIKE '%".$searchTerm."%' OR faddress LIKE '%".$searchTerm."%' OR filedesc LIKE '%".$searchTerm."%' OR fdeal LIKE '%".$searchTerm."%' OR currentresponsible LIKE '%".$searchTerm."%' OR createby_user LIKE '%".$searchTerm."%') AND createby_dept LIKE '%$current_location%' GROUP BY fileno";
											$result3 = mysqli_query($db,$query3);
											
											while ($row = mysqli_fetch_array($result2)) {
												$file_no   = $row[1];
												$file_name = $row[2];
												$file_desc = $row[6];
												$file_dealing_person = $row[7];
												$file_status = $row[14];
											?>
                                            <tr class="odd gradeX" <?php if($file_status == "Completed"){echo "style='color:green'";} ?>>
												<td><?php echo "$file_no";?></td>
                                                <td><?php echo "$file_name";?></td>
												<td><?php echo "$file_dealing_person";?></td>
												<td><?php echo "$file_desc";?></td>
												<td class="center"><a href='system_update_application.php?edit=<?php echo $file_no; ?>' style='color:#337ab7'>Edit</a></td>
												<td class="center"><a href='system_track_application.php?track=<?php echo $file_no; ?>' style='color:#337ab7'>Details</a></td>
                                            </tr>
											<?php
											}
											while ($row = mysqli_fetch_array($result1)) {
												$file_no   = $row[1];
												$file_name = $row[2];
												$file_desc = $row[6];
												$file_dealing_person = $row[7];
												$file_status = $row[14];
											?>
                                            <tr class="odd gradeX" <?php if($file_status == "Completed"){echo "style='color:green'";} ?>>
												<td><?php echo "$file_no";?></td>
                                                <td><?php echo "$file_name";?></td>
												<td><?php echo "$file_dealing_person";?></td>
												<td><?php echo "$file_desc";?></td>
												<td class="center"><a href='system_update_application.php?edit=<?php echo $file_no; ?>' style='color:#337ab7'>Edit</a></td>
												<td class="center"><a href='system_track_application.php?track=<?php echo $file_no; ?>' style='color:#337ab7'>Details</a></td>
                                            </tr>
											<?php
											}
											while ($row = mysqli_fetch_array($result3)) {
												$file_no   = $row[1];
												$file_name = $row[2];
												$file_desc = $row[6];
												$file_dealing_person = $row[7];
												$file_status = $row[14];
											?>
                                            <tr class="odd gradeX" <?php if($file_status == "Completed"){echo "style='color:green'";} ?>>
												<td><?php echo "$file_no";?></td>
                                                <td><?php echo "$file_name";?></td>
												<td><?php echo "$file_dealing_person";?></td>
												<td><?php echo "$file_desc";?></td>
												<td class="center"><a href='system_update_application.php?edit=<?php echo $file_no; ?>' style='color:#337ab7'>Edit</a></td>
												<td class="center"><a href='system_track_application.php?track=<?php echo $file_no; ?>' style='color:#337ab7'>Details</a></td>
                                            </tr>
											<?php
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
								<?php } ?>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /#page-wrapper -->
