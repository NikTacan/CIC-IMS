<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	$endUsers = $model->getEndUser();
	$designations = $model->getDesignation();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>


	<title>End User | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
				<li class="" style="margin-top: 0px;">
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 collapsed" style="text-color: #FFFFFF; color: #FFFFFF;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
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
                    <h2 class="p-0 mb-0">End Users</h2>

                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#create-endUser">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD END USER</span>
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
						<div id="create-endUser" class="modal fade" role="dialog">
							<form class="create-endUser m-b30" method="POST" enctype="multipart/form-data">
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
															<input class="form-control" type="text" name="firstName" value="" placeholder="Enter firstname" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Middle name</label>
															<input class="form-control" type="text" name="middleName" value="" placeholder="Enter middlename" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Last name</label>
															<input class="form-control" type="text" name="lastName" value="" placeholder="Enter lastname" maxlength="35" required>
														</div>
														<div class="form-group col-4">
															<label class="col-form-label">Birthday</label>
															<input class="form-control" type="date" name="birthday" value="" required max="<?php echo date('Y-m-d'); ?>" >
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
														<div class="form-group col-6">
															<label class="col-form-label">Email</label>
															<input class="form-control" type="text" name="email" value="" placeholder="Enter email address" maxlength="50" required>
														</div>
														<div class="form-group col-6">
															<label class="col-form-label">Contact</label>
															<input class="form-control" type="tel" name="contact" placeholder="0912-34-5678" name="contact" value="" size="11" maxlength="11" placeholder="Enter contact number" required>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="create-endUser" value="Save">
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
										<th class="col-3">Name of Accountable Officer</th>
										<th class="col-2">Designation</th>
										<th class="col-2">Status</th>
										<th class="col-2">Date Registered</th>
										<th class="text-center" width="10">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($endUsers)): ?>
										<?php foreach ($endUsers as $key => $endUser): ?>
											<?php $endUser_id = $endUser['id']; ?>
											<?php $status = $endUser['status']; ?>
											
											<tr>
												<td width="50"><?php echo $key + 1; ?></td>
												<td><?php echo $endUser['username']; ?></td>
												<td><?php echo $endUser['designation_name']; ?></td>
												<td>
													<?php if($status == '1'): ?>
														<button class="btn green btn-sm radius-xl " data-toggle="modal" data-target="#update-status-<?php echo $endUser_id; ?>" type="submit" name="view">
															<span class="d-none d-md-inline" data-toggle="tooltip" title="Inactivate">Active</span>
														</button>
													<?php else: ?>
														<button class="btn red radius-xl btn-sm" data-toggle="modal" data-target="#update-status-<?php echo $endUser_id; ?>" type="submit" name="view">
															<span class="d-none d-md-inline" data-toggle="tooltip" title="Activate">Inactive</span>
														</button>
													<?php endif; ?>
												</td>
												<td><?php echo date('F d, Y', strtotime($endUser['date_registered'])); ?></td>
												
												<td class="text-center">
													<center>
														<button class="btn green" onclick="window.location.href='end-user-view.php?id=<?php echo $endUser_id;?>'" type="submit" name="view"  style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="View">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
														<button data-toggle="modal" data-target="#update-endUser-<?php echo $endUser_id; ?>" class="btn blue" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Update">
																<i class="ti-marker-alt" style="font-size: 12px;"></i>
															</span>
														</button>
													</center>
												</td>
											</tr>

											<!-- Update Status -->
											<div id="update-status-<?php echo $endUser_id; ?>" class="modal fade" role="dialog">
												<form class="update-status m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-body">
																<input type="hidden" name="endUser_id" value="<?php echo $endUser_id; ?>">
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

											<!-- Update End user modal/form -->
											<div id="update-endUser-<?php echo $endUser_id; ?>" class="modal fade" role="dialog">
												<form class="update-endUser m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">&nbsp;Update Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="endUser_id" value="<?php echo $endUser_id; ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-8">
																				<label class="col-form-label">Username</label>
																				<input class="form-control" type="text" name="username" value="<?php echo $endUser['username']; ?>" maxlength="20" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Designation</label>
																				<select class="form-control" name="designation" required>
																					<?php if (!empty($designations)): ?>
																						<?php foreach ($designations as $update_designation): ?>
																							<option value="<?php echo $update_designation['id']; ?>" <?php if ($endUser['designation_id'] == $update_designation['id']) { echo 'selected'; } ?>>
																								<?php echo $update_designation['designation_name']; ?>
																							</option>
																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">First name</label>
																				<input class="form-control" type="text" name="firstName" value="<?php echo $endUser['first_name']; ?>" maxlength="15" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Middle name</label>
																				<input class="form-control" type="text" name="middleName" value="<?php echo $endUser['middle_name']; ?>" maxlength="35" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Last name</label>
																				<input class="form-control" type="text" name="lastName" value="<?php echo $endUser['last_name']; ?>" maxlength="35" required>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Birthday</label>
																				<input class="form-control" type="date" name="birthday" value="<?php echo $endUser['birthday']; ?>" required max="<?php echo date('Y-m-d'); ?>">
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Password</label>
																				<input class="form-control" type="password" name="password" value="<?php echo $endUser['password']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Sex</label>
																				<select name="sex" id="sex" class="form-control">
																					<option value="male" <?php if ($endUser['sex'] == 'male') echo 'selected'; ?>>Male</option>
																					<option value="female" <?php if ($endUser['sex'] == 'female') echo 'selected'; ?>>Female</option>
																				</select>
																			</div>
																			<div class="form-group col-6">
																				<label class="col-form-label">Email</label>
																				<input class="form-control" type="text" name="email" value="<?php echo $endUser['email']; ?>" maxlength="50" required>
																			</div>
																			<div class="form-group col-6">
																				<label class="col-form-label">Contact</label>
																				<input class="form-control" type="number" name="contact" value="<?php echo $endUser['contact']; ?>" maxlength="11" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update-endUser" value="Save Changes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Update End user modal/form -->

											<!-- Delete end user record form/modal -->
											<div id="delete-endUser-<?php echo $endUser_id; ?>" class="modal fade" role="dialog">
												<form class="delete-endUser m-b30" method="POST">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">&nbsp;Delete Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>															
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="endUser_id" value="<?php echo $endUser_id; ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-8">
																				<label class="col-form-label">Username</label>
																				<input class="form-control" type="text" name="username" value="<?php echo $endUser['username']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Designation</label>
																				<input class="form-control" type="text" name="username" value="<?php echo $endUser['designation_name']; ?>" readonly>
																				</select>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">First name</label>
																				<input class="form-control" type="text" name="firstName" value="<?php echo $endUser['first_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Middle name</label>
																				<input class="form-control" type="text" name="middleName" value="<?php echo $endUser['middle_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Last name</label>
																				<input class="form-control" type="text" name="lastName" value="<?php echo $endUser['last_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Birthday</label>
																				<input class="form-control" type="date" name="birthday" value="<?php echo $endUser['birthday']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Password</label>
																				<input class="form-control" type="password" name="password" value="<?php echo $endUser['password']; ?>" readonly>
																			</div>
																			<div class="form-group col-4">
																				<label class="col-form-label">Sex</label>
																				<input class="form-control" type="text" name="sex" value="<?php echo $endUser['sex']; ?>" readonly>
																			</div>

																			<div class="form-group col-6">
																				<label class="col-form-label">Email</label>
																				<input class="form-control" type="text" name="email" value="<?php echo $endUser['email']; ?>" readonly>
																			</div>
																			<div class="form-group col-6">
																				<label class="col-form-label">Contact</label>
																				<input class="form-control" type="number" name="contact" value="<?php echo $endUser['contact']; ?>" readonly>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="delete-endUser" value="Delete" onClick="return confirm('Delete This Record?')">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Delete end user record form/modal -->

										<?php endforeach; ?> <!-- table data end foreach -->
									<?php endif; ?> <!-- table data endif -->

								</tbody>
							</table>
						</div> <!-- End User table -->

						<?php
							/* Insert new end user controller */
							if (isset($_POST['create-endUser'])) {
								$username = $_POST['username'];
								$firstName = $_POST['firstName'];
								$middleName = $_POST['middleName'];
								$lastName = $_POST['lastName'];
								$birthday = $_POST['birthday'];
								$sex = $_POST['sex'];
								$email = $_POST['email'];
								$password = $_POST['password'];
								$contact = $_POST['contact'];
								$designation = $_POST['designation'];

								// Check if username already exists
								if ($model->usernameExists($username)) {

									$_SESSION['errorMessage'] = "Username already exist!";
									header("Location: end-user.php");
									exit();
								} else {

									$model->createEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $password, $contact, $designation);
									$_SESSION['successMessage'] = "New end user record added successfully!";
									header("Location: end-user.php");
									exit();
								}
							}

							if (isset($_POST['update-status'])) {
								$endUser_id = $_POST['endUser_id'];
							
								$old_values = $model->getEndUserDetailByID($endUser_id);
								$old_status = $old_values['status'];
							
							
								if ($old_status == '1') {
									$new_status = '0';
								} elseif ($old_status == '0') {
									$new_status = '1';
								}
							
								$updateUserStatus = $model->updateEndUserStatus($new_status, $endUser_id);
							
								$_SESSION['successMessage'] = "End user status updated successfully!";
								header("Location: end-user.php");
								exit();
							
							}
							

							/* Update End user record controller */
							if (isset($_POST['update-endUser'])) {
								$endUser_id = $_POST['endUser_id'];
								$username = $_POST['username'];
								$firstName = $_POST['firstName'];
								$middleName = $_POST['middleName'];
								$lastName = $_POST['lastName'];
								$birthday = $_POST['birthday'];
								$sex = $_POST['sex'];
								$email = $_POST['email'];
								$contact = $_POST['contact'];
								$designation = $_POST['designation'];

								$old_values = $model->getEndUserDetailByID($endUser_id);

								$updateRecord = $model->updateEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $contact, $designation, $endUser_id);
								$logRecord = $model->logEndUserUpdateTransaction($old_values, $_POST);

								$_SESSION['successMessage'] = "End user record updated successfully!";
								header("Location: end-user.php");
								exit();
							}

							/* Delete End user record controller */
							if (isset($_POST['delete-endUser'])) {
								$endUser_id = $_POST['endUser_id'];
								
								$EndUserAssignment = $model->hasAssignments($endUser_id);
						
								if (!empty($EndUserAssignment)) {

									$_SESSION['errorMessage'] = "Cannot delete user with existing assignments!";
									header("Location: end-user.php");
									exit();
								} else {
									$model->deleteEndUser($endUser_id);
									$_SESSION['successMessage'] = "End user record deleted successfully!";
									header("Location: end-user.php");
									exit();
								}

								ob_end_flush(); 
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