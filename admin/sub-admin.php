<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	$subAdmins = $model->getSubAdmin();
	$designations = $model->getDesignation();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>


	<title>Sub Admin | <?php echo $customize['sys_name']; ?></title>

</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar" style="background-color: #F3F3F3;">
	
<!-- main header -->
<?php include('../includes/layouts/main-layouts/ttr-header.php') ?>

		<nav class="ttr-sidebar-navi">
			<ul>
				<li style="padding-left: 20px; padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Main Navigation</span>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="index" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-home" aria-hidden="true"></i></span>
						<span class="ttr-label">Dashboard</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-database" aria-hidden="true"></i></span>
						<span class="ttr-label">Inventory</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="inventory-assignment" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>
						<span class="ttr-label">Assignment</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="end-user" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">End Users</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="category" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
						<span class="ttr-label">Categories</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="article" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cube" aria-hidden="true"></i></span>
						<span class="ttr-label">Article</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="report.php" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
						<span class="ttr-label">Report</span>
					</a>
				</li>
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
				</li>
				<li class="show" style="margin-top: 0px;">
					<a href="sub-admin" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">Sub Admin</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
							Settings
							</button>
							</h2>
						<div id="collapseSettings" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
						<div class="accordion-body p-0">
							<div class="">
								<a href="system-content" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">General Content</span>
								</a>
							</div>
							<div class="">
								<a href="customize" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">Components</span>
								</a>
							</div>
						</div>
					</div>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="archive-inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="ti-archive" aria-hidden="true"></i></span>
						<span class="ttr-label">Archives</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">

		<!-- Header and Button Row -->
		<div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Header aligned to the left -->
                    <h2 class="p-0 mb-0">Sub Admin</h2>

                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#create-subAdmin">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD SUB ADMIN</span>
                    </button>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="widget-inner">

						<?php if (!empty($successMessage)): ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<?php echo htmlspecialchars($successMessage); ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif; ?>

						<?php if (!empty($errorMessage)): ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<?php echo htmlspecialchars($errorMessage); ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif; ?>

						<!-- Create New End user modal/forms -->
						<div id="create-subAdmin" class="modal fade" role="dialog">
							<form class="create-subAdmin m-b30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">&nbsp;Add End user Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="form-group col-12" style="padding-bottom: 15px;">
													<div class="row">
													<div class="form-group col-8">
															<label class="col-form-label">Username</label>
															<input class="form-control" type="text" name="username" value="" placeholder="Enter username" maxlength="20" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Password</label>
															<input class="form-control" type="text" name="password" value="" placeholder="Enter password" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">First name</label>
															<input class="form-control" type="text" name="firstname" value="" placeholder="Enter firstname" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Middle name</label>
															<input class="form-control" type="text" name="middlename" value="" placeholder="Enter middlename" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Last name</label>
															<input class="form-control" type="text" name="lastname" value="" placeholder="Enter lastname" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Designation</label>
															<select class="form-control" name="designation" required>
																<option value="" selected disabled hidden>-- Select designation --</option>
																<?php if(!empty($designations)):  ?>
																	<?php foreach ($designations as $add_designation):  ?>
																			
																	<option value="<?php echo $add_designation['id']; ?>"><?php echo $add_designation['designation_name']; ?></option>

																	<?php endforeach; ?>
																<?php endif; ?>
															</select>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Gender</label>
															<select name="sex" id="sex">
																<option value="" selected hidden>-- Select gender --</option>
																<option value="Male">Male</option>
																<option value="Female">Female</option>
															</select>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Contact</label>
															<input class="form-control" type="tel" name="contact" placeholder="0912-34-5678" name="contact" value="" size="11" maxlength="11" placeholder="Enter contact number" required>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="create-subAdmin" value="Save">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Create New End user modal/form -->

						<!-- End User table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-1">#</th>
										<th class="col-3">Username</th>
										<th class="col-2">Designation</th>
										<th class="col-2">Status</th>
										<th class="col-2">Date Registered</th>
										<th class="col-1 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($subAdmins)): ?>
										<?php foreach ($subAdmins as $key => $subAdmin): ?>
											<?php 
												$subAdmin_id = $subAdmin['sub_admin_id'];
											 	$status = $subAdmin['status']; 
											 	$user_id = $subAdmin['user_id'];
											 ?>
										
											
											<tr>
												<td width="50"><?php echo $key + 1; ?></td>
												<td><?php echo $subAdmin['username']; ?></td>
												<td><?php echo $subAdmin['designation_name']; ?></td>
												<td>
													<?php if($status == '1'): ?>
														<button class="btn green btn-sm radius-xl " data-toggle="modal" data-target="#update-status-<?php echo $subAdmin_id; ?>" type="submit" name="view">
															<span class="d-none d-md-inline" data-toggle="tooltip" title="Inactivate">Active</span>
														</button>
													<?php else: ?>
														<button class="btn red radius-xl btn-sm" data-toggle="modal" data-target="#update-status-<?php echo $subAdmin_id; ?>" type="submit" name="view">
															<span class="d-none d-md-inline" data-toggle="tooltip" title="Activate">Inactive</span>
														</button>
													<?php endif; ?>
												</td>
												<td><?php echo date('F d, Y', strtotime($subAdmin['date_registered'])); ?></td>
												
												<td class="text-center">
													<center>
														<button data-toggle="modal" data-target="#update-subAdmin-<?php echo $subAdmin_id; ?>" class="btn blue" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Update">
																<i class="ti-marker-alt" style="font-size: 12px;"></i>
															</span>
														</button>
													</center>
												</td>
											</tr>

											<!-- Update Status -->
											<div id="update-status-<?php echo $subAdmin_id; ?>" class="modal fade" role="dialog">
												<form class="update-status m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-body">
																<input type="hidden" name="subAdmin_id" value="<?php echo $subAdmin_id; ?>">
																<div class="row">
																	<div class="form-group col-12 py-1 mt-2">
																		<div class="row">
																			<p>Are you sure do you want change user status?</p>
																		</div>
																	</div>
																</div>
															</div>
															<?php 
															
															?>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update-status" value="Yes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Cancel</button>
															</div>
														</div>
													</div>
												</form>
											</div>
											<!-- -->

											<!-- Update Sub admin modal/form -->
											<div id="update-subAdmin-<?php echo $subAdmin_id; ?>" class="modal fade" role="dialog">
												<form class="update-subAdmin m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">&nbsp;Update Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="subAdmin_id" value="<?php echo $subAdmin_id; ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-8">
																				<label class="col-form-label">Username</label>
																				<input class="form-control" type="text" name="username" value="<?php echo $subAdmin['username']; ?>" maxlength="20" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Password</label><br>
																				<a href="#" class="text-primary" data-toggle="modal" data-target="#reset-password-<?php echo $user_id; ?>" style="text-decoration: underline; cursor: pointer;">
																					Reset Password
																				</a>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">First name</label>
																				<input class="form-control" type="text" name="firstname" value="<?php echo $subAdmin['first_name']; ?>" maxlength="15" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Middle name</label>
																				<input class="form-control" type="text" name="middlename" value="<?php echo $subAdmin['middle_name']; ?>" maxlength="35" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Last name</label>
																				<input class="form-control" type="text" name="lastname" value="<?php echo $subAdmin['last_name']; ?>" maxlength="35" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Sex</label>
																				<select name="sex" id="sex" class="form-control">
																					<option value="male" <?php if ($subAdmin['sex'] == 'male') echo 'selected'; ?>>Male</option>
																					<option value="female" <?php if ($subAdmin['sex'] == 'female') echo 'selected'; ?>>Female</option>
																				</select>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Designation</label>
																				<select class="form-control" name="designation" required>
																					<?php if (!empty($designations)): ?>
																						<?php foreach ($designations as $update_designation): ?>
																							<option value="<?php echo $update_designation['id']; ?>" <?php if ($subAdmin['designation_id'] == $update_designation['id']) { echo 'selected'; } ?>>
																								<?php echo $update_designation['designation_name']; ?>
																							</option>
																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Contact</label>
																				<input class="form-control" type="number" name="contact" value="<?php echo $subAdmin['contact']; ?>" maxlength="11" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update-subAdmin" value="Save Changes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Update Sub admin modal/form -->

											<!-- reset password modal -->
											<div id="reset-password-<?php echo $user_id; ?>" class="modal fade" role="dialog">
												<form class="edit-info m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Change Password</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
																	<p>Are you sure you want to reset your password to default?</p>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="reset-password" value="Reset Password">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- reset password modal -->

										<?php endforeach; ?> <!-- table data end foreach -->
									<?php endif; ?> <!-- table data endif -->

								</tbody>
							</table>
						</div> <!-- End User table -->

						<?php
							/* Insert new end user controller */
							if (isset($_POST['create-subAdmin'])) {
								$username = $_POST['username'];
								$firstname = $_POST['firstname'];
								$middlename = $_POST['middlename'];
								$lastname = $_POST['lastname'];
								$sex = $_POST['sex'];
								$password = $_POST['password'];
								$contact = $_POST['contact'];
								$designation = $_POST['designation'];

								// Check if username already exists
								if ($model->usernameExists($username)) {

									$_SESSION['errorMessage'] = "Username already exist!";
									header("Location: sub-admin.php");
									exit();
								} else {

									$model->createSubAdmin($username, $firstname, $middlename, $lastname, $sex, $password, $contact, $designation);
									$_SESSION['successMessage'] = "New sub admin record added successfully!";
									header("Location: sub-admin.php");
									exit();
								}
							}

							if (isset($_POST['update-status'])) {
								$subAdmin_id = $_POST['subAdmin_id'];
							
								$old_values = $model->getSubAdminByID($subAdmin_id);
								$old_status = $old_values['status'];
							
							
								if ($old_status == '1') {
									$new_status = '0';
								} elseif ($old_status == '0') {
									$new_status = '1';
								}
							
								$updateUserStatus = $model->updateSubAdminStatus($new_status, $subAdmin_id);
							
								$_SESSION['successMessage'] = "User status updated successfully!";
								header("Location: sub-admin.php");
								exit();
							
							}
							

							/* Update End user record controller */
							if (isset($_POST['update-subAdmin'])) {
								$subAdmin_id = $_POST['subAdmin_id'];
								$username = $_POST['username'];
								$firstname = $_POST['firstname'];
								$middlename = $_POST['middlename'];
								$lastname = $_POST['lastname'];
								$sex = $_POST['sex'];
								$contact = $_POST['contact'];
								$designation = $_POST['designation'];

								$old_values = $model->getSubAdminByID($subAdmin_id);

								// Check if username already exists
								if ($model->usernameExists($username)) {

									$_SESSION['errorMessage'] = "Username already exist!";
									header("Location: sub-admin.php");
									exit();
								} else {

									$updateRecord = $model->updateSubAdmin($username, $firstname, $middlename, $lastname, $sex,$contact, $designation, $subAdmin_id);
									$logRecord = $model->logEndSubAdminUpdateTransaction($old_values, $_POST);
									
									$_SESSION['successMessage'] = "Sub admin record updated successfully!";
									header("Location: sub-admin.php");
									exit();
								}
							}

							/* Reset user password controller */
							if(isset($_POST['reset-password'])) {
								$user_id = $_POST['user_id'];

								$model->resetUserPassword($user_id);

								$_SESSION['successMessage'] = "Password reset to default successfully!";
								header("Location: sub-admin.php");
								exit();

							}

						?>
								
					</div> <!-- widget-inner -->
				</div> <!-- widget-box --> 
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

</body>
</html>