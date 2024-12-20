<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	if (isset($_GET['id'])) {
		$user_id = $_GET['id'];

		$user = $model->getAdminInfo($user_id);
		
	}
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>User Details | <?php echo $customize['sys_name']; ?></title>

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
				<?php if($userInfo['role_id'] == 1): ?>
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
				</li>
				<li class="" style="margin-top: 0px;">
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
				<?php else: ?>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">
		<div class="row" width="100%">
			<div class="account-profile col-lg-12" style="margin-left:"> 	

				<div class="float-left">
					<h2 class="title-head float-left">Account<span class="fw-normal"> Profile</span></h2>
				</div><br><br><br>
				
				<div class="row">
					<div class="widget-box ">
						<div class="widget-inner">
							
							<!-- Alert notification -->
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
							<?php endif; ?> <!-- Alert notification -->

							<div class="profile-content row col-6">

								<h3><?php echo $user['username']; ?></h3>

						

								<!-- Profile Page -->
								<div class="float-left">

									<!-- Edit Profile button -->
									<div class="float-left my-1">
										<button type="button" class="btn blue radius-xl" data-toggle="modal" data-target="#update-user-<?php echo $user_id; ?>">
											<i class="ti-marker-alt" title="Edit"></i>
											<span data-toggle="tooltip">&nbsp;&nbsp;Edit Profile</span>
										</button>
									</div> <!-- Edit Profile button --> 

									<!-- Reset Password button -->
									<div class="float-left mx-1 my-1">
										<button type="button" class="btn red radius-xl" data-toggle="modal" data-target="#reset-password-<?php echo $user_id; ?>">
											<i class="ti-key" title="Reset Password"></i>
											<span data-toggle="tooltip">&nbsp;&nbsp;Reset Password</span>
										</button>
									</div>

									<!-- Change Password button -->
									<div class="float-left mx-1 my-1">
										<button type="button" class="btn green radius-xl" data-toggle="modal" data-target="#change-password-<?php echo $user_id; ?>">
											<i class="ti-lock" title="Change Password"></i>
											<span data-toggle="tooltip">&nbsp;&nbsp;Change Password</span>
										</button>
									</div>

								</div> <!-- Profile Page -->

								<!-- update user info modal -->
								<div id="update-user-<?php echo $user_id; ?>" class="modal fade" role="dialog">
									<form class="edit-info m-b30" method="POST" enctype="multipart/form-data">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Update Username</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<div class="row">
														<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
														<div class="form-group col-12" style="padding-bottom: 15px;">
															<div class="row">
																<div class="form-group col-12">
																	<label class="col-form-label">Username</label>
																	<input class="form-control" type="text" name="username" value="<?php echo $user['username']; ?>" required>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" class="btn green radius-xl outline" name="update-user" value="Save Changes">
													<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</form>
								</div> <!-- update address modal -->

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

								<!-- change password modal -->
								<div id="change-password-<?php echo $user_id; ?>" class="modal fade" role="dialog">
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
														<div class="form-group col-12" style="padding-bottom: 15px;">
															<div class="row">
																<div class="form-group col-12">
																	<label for="new-password">Old Password</label>
																	<div class="input-group">
																		<input class="form-control" type="password"  id="old-password" name="old-password" required>
																		<div class="input-group-text">
																			<i class="fa fa-eye" id="old-password-toggle"></i>
																		</div>
																	</div>
																</div>
																<div class="form-group col-12">
																	<label for="new-password">New Password</label>
																	<div class="input-group">
																		<input class="form-control" type="password"  id="new-password" name="new-password" required>
																		<div class="input-group-text">
																			<i class="fa fa-eye" id="new-password-toggle"></i>
																		</div>
																	</div>
																</div>
																<div class="form-group col-12">
																	<label for="confirm-password">Confirm New Password</label>
																	<div class="input-group">
																		<input class="form-control" type="password"  id="confirm-password" name="confirm-password" required>
																		<div class="input-group-text">
																			<i class="fa fa-eye" id="confirm-password-toggle"></i>
																		</div>
																	</div>
																	<span id="password-mismatch-message" style="font-size: 13px; color: red;"></span>	
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" class="btn green radius-xl outline" name="change-password" value="Change Password">
													<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</form>
								</div> <!-- change password modal -->
								
							</div> <!-- prifle content row -->

							<?php

								/* Update user profile record controller */
								if (isset($_POST['update-user'])) {
									$user_id = $_POST['user_id'];
									$username = $_POST['username'];

									// Check if username already exists
									if ($model->usernameExists($username)) {

										$_SESSION['errorMessage'] = "Username already exist!";
										header("Location: user-view.php?id=$user_id");
										exit();
									} else {
										$model->updateUserUsername($username, $user_id);

										$_SESSION['successMessage'] = "Username updated successfully!";
										header("Location: user-view.php?id=$user_id");
										exit();
									}
								}

								/* Reset user password controller */
								if(isset($_POST['reset-password'])) {
									$user_id = $_POST['user_id'];

									$model->resetUserPassword($user_id);

									echo "<script>alert('Password has been reset successfully. Please log out and log back in to apply changes.');window.open('logout.php', '_self')</script>";

								}

								/* Update user password controller */
								if(isset($_POST['change-password'])) {
									$user_id = $_POST['user_id'];
									$old_password = $_POST['old-password'];
									$new_password = $_POST['new-password'];
									$confirm_password = $_POST['confirm-password'];

									$verifyPassword = $model->getUserInfo($user_id);
									if ($new_password == $confirm_password) {
										if (password_verify($old_password, $verifyPassword['password'])) {
		
											$model->updateUserPassword($user_id, $new_password);
											echo "<script>alert('Password has been changed successfully. Please log out and log back in to apply changes.');window.open('logout.php', '_self')</script>";
										} else {
											echo "<script>alert('Old password does not match.');window.open('user-view?id=$user_id', '_self')</script>";
										}

									} else {
										echo "<script>alert('New password and confirm password do not match.');</script>";
									}
									
								}
							
							
							?>

						</div> <!-- widger inner -->
					</div> <!-- widget box -->
				</div> <!-- row --> 
			</div> <!-- account profile -->
		</div> <!-- row -->
	</div> <!-- container fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	<?php include('../includes/js/preloader.php'); ?>

	<script>
		
        // Function to toggle password visibility
        function togglePasswordVisibility(inputId, toggleId) {
            var input = document.getElementById(inputId);
            var toggle = document.getElementById(toggleId);
            if (input.type === "password") {
                input.type = "text";
                toggle.classList.remove("fa-eye");
                toggle.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                toggle.classList.remove("fa-eye-slash");
                toggle.classList.add("fa-eye");
            }
        }

        // Event listeners for toggling password visibility
        document.getElementById("old-password-toggle").addEventListener("click", function() {
            togglePasswordVisibility("old-password", "old-password-toggle");
        });

        document.getElementById("new-password-toggle").addEventListener("click", function() {
            togglePasswordVisibility("new-password", "new-password-toggle");
        });

        document.getElementById("confirm-password-toggle").addEventListener("click", function() {
            togglePasswordVisibility("confirm-password", "confirm-password-toggle");
        });
	</script>

</body>
</html>