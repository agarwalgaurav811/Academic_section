<?php include("session.php"); ?>
			<!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="system.php">Admin - Central Login System</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php if($user_image !=''){ ?>
                            <img src="images/<?php echo $user_image; ?>" width="35" style="border-radius:20px;">
						<?php }else{ ?>
							<i class="fa fa-user fa-fw"></i>
						<?php } 
							echo $name; ?> <b class="caret"></b>
							
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="system_profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form" style="text-align:center;">
                                   <a href="system.php"><img width="45%" src="images/logo.png"></a>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="system.php"><i class="fa fa-home fa-fw"></i> Home</a>
                            </li>
							<?php if($current_dept != '104'){ ?>
							<li>
                                <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Application Entry<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="system_create_new.php">Add New Entry</a>
                                    </li>
                                    <li>
                                        <a href="system_search.php">Search Entry</a>
                                    </li>
									<li>
                                        <a href="system_backdate_entry.php">Backlog Entry</a>
                                    </li>
									<li>
                                        <a href="system_external_application.php">External Applications</a>
                                    </li>
									<li>
                                        <a href="export_data.php">Download Records</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
							<?php } ?>
							<li>
                                <a href="#"><i class="fa fa-bed fa-fw"></i> Guesthouse Booking<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="system_guesthouse_new_applications.php">Unread Applications</a>
                                    </li>
                                    <li>
                                        <a href="system_guesthouse_applications.php">Search Old Applications</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
							<?php if($current_dept == '104'){ ?>
							<li>
                                <a href="#"><i class="fa fa-warning fa-fw"></i> Rooms Non-Availibility<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="system_add_non_availibility.php">Add new dates</a>
                                    </li>
                                    <li>
                                        <a href="system_track_non_availibility.php">Previous Non-Availibility</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
							<?php } 
							if($current_dept != '104'){ ?>
							<li>
                                <a href="#"><i class="fa fa-globe fa-fw"></i> SA Main Website<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="system_all_forms.php">Forms</a>
                                    </li>
                                    <li>
                                        <a href="system_all_announcements.php">Announcements</a>
                                    </li>
									<li>
                                        <a href="system_all_achievements.php">Achievements</a>
                                    </li>
									<li>
                                        <a href="system_all_rules.php">Rules Dropdown</a>
                                    </li>
									<li>
                                        <a href="system_all_sac_minutes.php">SAC Minutes</a>
                                    </li>
									<li>
                                        <a href="system_all_quick_links.php">Quick Links</a>
                                    </li>
									<li>
                                        <a href="system_all_team_members.php">Team Members</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
							<li>
                                <a href="system_track_departure_arrival_info.php"><i class="fa fa-bus fa-fw"></i> Station Leave Request</a>
                            </li>
							<?php } ?>
							<li>
                                <a href="system_student_details.php"><i class="fa fa-users fa-fw"></i> Search Student's Details</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>