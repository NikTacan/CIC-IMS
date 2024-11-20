<?php include('../includes/session.php'); ?>
<?php include('../includes/upload-image.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	$info_id = $customize['id'];
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Content Management | <?php echo $customize['sys_name']; ?></title>

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
					<a href="category" class="ttr-material-buttons">
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
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
							Settings
							</button>
							</h2>
						<div id="collapseSettings" class="accordion-collapse show" data-bs-parent="#accordionSettings">
						<div class="accordion-body p-0">
							<div class="show">
								<a href="system-content" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon-show"></span>
									<span class="ttr-label-show">General Content</span>
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
		
		<!-- Header title -->
		<div clas="ttr-header">
			<div class="float-left">
				<h2 class="title-head float-left">General Content<span class="fw-normal"> Settings</span></h2>
			</div><br><br><br>
		</div> <!-- Header title -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="widget-inner"> 

						<!-- alert notification -->
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
						<?php endif; ?> <!-- alert notification -->

						<!-- address & logo -->
						<div class="row">

							<!-- address -->
							<div class="form-group col-lg-12 col-xl-6 px-3">
								<div class="row">
									<div class="form-group col-12" >
										<div style="border-left: 5px solid #5ADA86; height: 32px;">
										<h3 class="ms-2 fw-normal">Information</h3></div>
									</div>
									<div class="form-group col-12 my-4">
										<h4><?php echo $customize['sys_name']; ?><br>
										<span class="fw-light" style="font-size: 17px;">System Title</span>
										</h4>
									</div>
									<div class="form-group col-12">
										<h4><?php echo $customize['address']; ?><br>
										<span class="fw-light" style="font-size: 17px;">Address</span>
										</h4>
									</div>
									<div class="form-group col-12">
										<button type="button" class="btn green radius-xl" style="float: left; background-color: #5ADA86;" data-toggle="modal" data-target="#update-address-<?php echo $info_id; ?>">
										<i class="ti-marker-alt" title="Edit"></i>
										<span data-toggle="tooltip">&nbsp;&nbsp;Edit Information</span>
										</button>
									</div>
								</div>		
							</div> <!-- address -->

							<!-- update address modal -->
							<div id="update-address-<?php echo $info_id; ?>" class="modal fade" role="dialog">
								<form class="edit-info m-b30" method="POST" enctype="multipart/form-data">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Update Record</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<input type="hidden" name="info_id" value="<?php echo $info_id ?>">
													<div class="form-group col-12" style="padding-bottom: 15px;">
														<div class="row">
															<div class="form-group col-12">
																<label class="col-form-label">System title</label>
																<input class="form-control" type="text" name="sys_name" value="<?php echo $customize['sys_name']; ?>" required>
															</div>
															<div class="form-group col-12">
																<label class="col-form-label">Address</label>
																<input class="form-control" type="text" name="address" value="<?php echo $customize['address']; ?>" required>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn green radius-xl outline" name="update-address" value="Save Changes">
												<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</form>
							</div> <!-- update address modal -->


							<!-- logo -->
							<div class="form-group col-lg-12 col-xl-6 px-3">
								<div class="row">
									<div class="info-head form-group col-12" >
										<div style="border-left: 5px solid #5ADA86; height: 32px;">
										<h3 class="ms-2 fw-normal">Logo</h3></div>
									</div>
									<div class="info-body col-12 my-5" style="height: 120px;">
										<img src="../assets/images/<?php echo $customize['logo_file']; ?>" class="img-fluid" alt="..." style="display: relative; width: 100px;">
									</div>
									<div class="info-footer form-group col-12">
										<button type="button" class="btn green radius-xl" style="float: left; background-color: #5ADA86;" data-toggle="modal" data-target="#update-logo-<?php echo $info_id; ?>">
										<i class="ti-marker-alt" title="Edit"></i>
										<span data-toggle="tooltip">&nbsp;&nbsp;Edit Details</span>
										</button>
									</div>
								</div>		
							</div> <!-- logo -->

							<!-- update logo modal -->
							<div id="update-logo-<?php echo $info_id; ?>" class="modal fade" role="dialog">
								<form class="edit-logo m-b30" method="POST" enctype="multipart/form-data">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Update Record</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<input type="hidden" name="info_id" value="<?php echo $info_id ?>">
													<div class="form-group col-12" style="padding-bottom: 15px;">
														<div class="row">
															<div class="form-group col-12">
																<label class="col-form-label">Upload Logo</label>
																<input class="form-control"  type="file" name="logo-file" id="logo-file" required>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn green radius-xl outline" name="update-logo" value="Upload">
												<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</form>
							</div> <!-- update logo modal -->

						</div><!-- address & logo row -->

						<div class="divider" style="border-top: 1px solid #D0D0D0; margin-top: 0px; margin-bottom: 30px;"></div>
						

						<!-- other content -->
						<div class="row">

							<!-- Login background image -->
							<div class="form-group col-lg-12 col-xl-6 px-3">
								<div class="row">
									<div class="info-head form-group col-12" >
										<div style="border-left: 5px solid #5ADA86; height: 32px;">
										<h3 class="ms-2 fw-normal">Log-in Content</h3></div>
									</div>

									<div class="col-lg-6 col-xl-6" style="position: relative;">
										<div class="info-body col-12 my-3 px-0" style="height: 270px;">
											<img src="../assets/images/<?php echo $customize['login_image']; ?>" class="img-fluid" alt="..." style=" height: 250px; width: 200px;">
											<div class="row">
												<span class="fw-light" style="font-size: 17px;">Login Background Image</span>
											</div>
										</div>
										<div class="info-footer col-12 px-0 my-2" style="float: left; position: relative;">
											<button type="button" class="btn green radius-xl" style=" background-color: #5ADA86;" data-toggle="modal" data-target="#update-login-image-<?php echo $info_id; ?>">
												<i class="ti-marker-alt" title="Edit"></i>
												<span data-toggle="tooltip">&nbsp;&nbsp;Edit Details</span>
											</button>
										</div>
									</div>

								</div>	
								
								<!-- update login background image modal -->
								<div id="update-login-image-<?php echo $info_id; ?>" class="modal fade" role="dialog">
									<form class="edit-login-image m-b30" method="POST" enctype="multipart/form-data">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Update Login Image</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<div class="row">
														<input type="hidden" name="info_id" value="<?php echo $info_id ?>">
														<div class="form-group col-12" style="padding-bottom: 15px;">
															<div class="row">
																<div class="form-group col-12">
																	<label class="col-form-label">Upload Image</label>
																	<input class="form-control"  type="file" name="login-image-background" id="login-image-background" required>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" class="btn green radius-xl outline" name="update-login-image" value="Upload">
													<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</form>
								</div> <!-- update login background image modal -->

							</div> <!-- Login background image -->

							

							<!-- Change system theme -->
							<div class="col-xl-6 col-sm-12">
								<div class="info-head form-group col-12" >
										<div style="border-left: 5px solid #5ADA86; height: 32px;">
										<h3 class="ms-2 fw-normal">Theme</h3></div>
									</div>
								<div  class="col-12 mx-0 px-0" style="float: left;">
									<form action="system-content" method="POST"> <!-- Assuming update-theme.php handles form submission -->
										<?php

											$themes = array(
												array("id" => 1, "name" => "Theme 1", "color1" => "#5ADA86", "color2" => "#0D0D0D"),

												// Maroon
												array("id" => 2, "name" => "Theme 2", "color1" => "#800000", "color2" => "#EEEEEE"),
												// Green
												
												// Grey
												array("id" => 3, "name" => "Theme 3", "color1" => "#66655E", "color2" => "#EEEEEE")
											);
										?>

										<?php foreach ($themes as $theme): ?>
											<div class="col-6 mt-3" style="align-items: start;">
												<div style="border-style: solid; border-width: 1px; height: 50px; width: 200px; background-color:<?php echo $theme['color2'] ?>;"></div>
												<div style="border-style: solid; border-width: 1px; height: 50px; width: 200px; background-color:<?php echo $theme['color1'] ?>;"></div>
												<div><span class="fw-light" style="font-size: 17px;"><input style="font-size: 45px; margin-top: 5px; margin-right: 5px;" type="checkbox" name="selected_theme[]" value="<?php echo $theme['id'] ?>" <?php echo ($theme['id'] == $theme_id ? 'checked' : '') ?>><?php echo $theme['name'] ?></h4></div>
											</div>

										<?php endforeach; ?>
										<div class="info-footer col-12 px-0 my-2" style="float: left; position: relative;">
											<button type="submit" class="btn green radius-xl" style=" background-color: #5ADA86;">
												<i class="ti-marker-alt" title="Update"></i>
												<span data-toggle="tooltip">&nbsp;&nbsp;Change theme</span>
											</button>
										</div>
									</form>
								</div>
								<div class="col-12 float-left" style="margin-top: 20px;">
								</div>
							</div> <!-- other contents -->

						</div><!-- other content row -->

						<?php
				
						/* Update address in customize record controller */
						if (isset($_POST['update-address'])) {
							$sys_name = $_POST['sys_name'];
							$address = $_POST['address'];

							$old_values = $model->displayReportEdit();

							$updateContent = $model->updateContent($sys_name, $address);
							$logUpdate = $model->logContentUpdateTransaction($old_values, $_POST);

							$_SESSION['successMessage'] = "System information updated succesfully!";
							header("Location: system-content.php");
							exit();
						}

						/* Update theme controller */
						if (isset($_POST['selected_theme'])) {
							$selectedTheme = $_POST['selected_theme'][0];

							$success = $model->updateSystemTheme($selectedTheme);

							if ($success) {
								$_SESSION['successMessage'] = "System theme updated succesfully!";
								header("Location: system-content.php");
								exit();
							} else {
								$_SESSION['errorMessage'] = "System theme update unsuccesful";
								header("Location: system-content.php");
								exit();
							}
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