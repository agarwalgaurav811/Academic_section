<?php 
	include("session.php");
	error_reporting(0);
?>
			<div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Recent 10 Entries
                            </div>
							<?php if($current_dept == '104'){
								$query2 = "SELECT * FROM gh_booking WHERE reach_est = 'yes' ORDER BY booking_time DESC ";
								$result2 = mysqli_query($db,$query2);
								$isindb    = mysql_num_rows($result2);
							?>
							<div class="panel-body">
								<?php if($isindb == 1){ ?>
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="">
										<thead>
											<tr> 
											  <th valign="top" bgcolor="#dedede"> <font>Application No.</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Applicant</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Booking From</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Booking Upto</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Status</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Details</font></th>
											</tr>
										</thead>
										<tbody>
										<?php
											while ($row = mysqli_fetch_array($result2)) {
												$id = $row[0];
												$gh_application_no = $row[1];
												$applied_on   = $row[27];
												$from = $row[9];
												$to = $row[10];
												$student_name = $row[3];
												$status = $row[29];
												$allotted_room = $row[43];
											?>
                                            <tr class="odd gradeX" <?php if($status == "Allotted"){echo "style='color:green'";}?>>
												<td><?php echo "$gh_application_no";?></td>
												<td><?php echo "$student_name";?></td>
                                                <td><?php echo "$from";?></td>
												<td><?php echo "$to";?></td>
                                                <td><?php if($status == "Allotted"){echo "<span style='color:green;'>Room Allotted (".$allotted_room.")</span>";} else{echo $status;} ?></td>
												<td class="center"><a href='system_track_guesthouse_application_details.php?track=<?php echo $gh_application_no; ?>' style='color:#337ab7'>Details</a></td>
                                            </tr>
											<?php
											}
											?>
										</tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
								<?php }
								else{
									echo "No new application.";
								}
								?>
							</div>
                            <!-- /.panel-body -->
							<?php } else { ?>
							<div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="">
										<thead>
											<tr> 
											  <th valign="top" bgcolor="#dedede"> <font>Entry Time</font></th>
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
											$query2 = "SELECT * FROM acad_files ORDER BY datecreate DESC LIMIT 10";
											$result2 = mysqli_query($db,$query2);
										
											while ($row = mysqli_fetch_array($result2)) {
												$file_no   = $row[1];
												$file_name = $row[2];
												$file_desc = $row[6];
												$file_dealing_person = $row[7];
												$entry_time   = $row[9];
												$file_status = $row[14];
											?>
                                            <tr class="odd gradeX" <?php if($file_status == "Completed"){echo "style='color:green'";} ?>>
												<td><?php echo "$entry_time";?></td>
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
							</div>
                            <!-- /.panel-body -->
							<?php } ?>
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /#page-wrapper -->
 
