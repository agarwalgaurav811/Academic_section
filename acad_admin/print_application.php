<?php 
	include("session.php");
	error_reporting(0);
?>
			<!-- Bootstrap Core CSS -->
			<link href="css/bootstrap.min.css" rel="stylesheet">

			<!-- MetisMenu CSS -->
			<link href="css/metisMenu.min.css" rel="stylesheet">

			<!-- Custom CSS -->
			<link href="css/startmin.css" rel="stylesheet">
			
			
			<!-- DataTables CSS -->
			<link href="css/dataTables.bootstrap.css" rel="stylesheet">

			<!-- DataTables Responsive CSS -->
			<link href="css/dataTables.responsive.css" rel="stylesheet">

			<!-- Custom Fonts -->
			<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
			<div id="page-wrapper" style="width:100%;margin:auto;border-left:0px">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						<div class="logo" style="text-align:center;">
							<img style="width:45%;margin-bottom:4%" src="images/logo_print.png">
						</div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Application No.: <b><?php $id = $_GET['print']; echo $id; ?></b>
                            </div>
							<div class="panel-body">
								<div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
										<?php
											include("connect.php");
											$id = $_GET['print'];
											$query = "SELECT * FROM acad_files WHERE fileno = '$id'";
											$result = mysqli_query($db,$query);
											$row_track = mysqli_fetch_array($result);
										?>
                                            <tr>
                                                <td><b>Application No.:</b> <?php echo $row_track["fileno"]; ?></td>
                                                <td><b>Current Status:</b> <?php if($row_track["status"] == "Completed"){echo "<span style='color:green;'>Process Completed</span>";} else{echo "Under Process";} ?></td>
                                                
                                            </tr>
                                            <tr>
                                                <td><b>Application Date:</b> <?php echo $row_track["fdate"]; ?></td>
                                                <td><b>Entry Time:</b> <?php echo $row_track["datecreate"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Applicant:</b> <?php echo $row_track["filename"]; ?></td>
												<td><b>Applicant Webmail:</b> <?php echo $row_track["applicant_webmail"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Addressed to:</b> <?php echo $row_track["faddress"]; ?></td>
                                                <td><b>Dealing Person:</b> <?php echo $row_track["fdeal"]; ?></td>
                                            </tr>
											<tr>
                                                <td><b>Created By (staff name):</b> <?php echo $row_track["createby_user"]; ?></td>
                                                <td><b>Created By (section/department name):</b> <?php echo $row_track["createby_dept"]; ?></td>
                                            </tr>
											<tr>
                                                <td><b>Current File Location:</b> <?php echo $row_track["currentloc"]; ?></td>
                                                <td><b>Current Responsible Person:</b> <?php echo $row_track["currentresponsible"]; ?></td>
                                            </tr>
											<tr>
                                                <td colspan="2"><b>Application Description:</b> <?php echo $row_track["filedesc"]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="">
										<thead>
											<tr> 
											  <th valign="top" bgcolor="#dedede"> <font>Date and Time</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Last File Location</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Updated By</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Forwarded to</font></th>
											  <th valign="top" bgcolor="#dedede"> <font>Comments</font></th>
											</tr>
										</thead>
										<tbody>
										<?php
											include("connect.php");
											$id = $_GET['print'];
											$query3 = "SELECT * FROM movement WHERE filesNo = '$id'";
											$result3 = mysqli_query($db,$query3);
												while($row = mysqli_fetch_array($result3)){
												
														$location = $row[5];
														$responsible = $row[7];
														$comment = $row[8];
														$initiator = $row[10];
														$datetime = $row[11];
														echo "<tr class='odd'>";
														
														echo "<td><font size='2' color = 'red'><b>$datetime</b>";	
														echo "<td><font size='2'>$location";	
														echo "<td><font size='2'>$initiator";	
														echo "<td><font size='2'>$responsible";		
														echo "<td><font size='2'>$comment";
														echo "</tr>";
														}
											?>
										</tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /#page-wrapper -->
 
