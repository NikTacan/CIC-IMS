<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php 
	$locationDetails = $model->getLocationWithCounts();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Location | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
	<div class="container-fluid" style="margin-right: 50%;">

		<!-- Header and Button Row -->
		<div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Header aligned to the left -->
                    <h2 class="p-0 mb-0">Location</h2>

					<?php if($userInfo['role_id'] == 1): ?>
                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#insert-location">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD LOCATION</span>
                    </button>
					<?php endif; ?>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
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
						
						<!-- Insert location record modal -->
						<div id="insert-location" class="modal fade" role="dialog">
							<form class="insert-location m-b30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-md">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">&nbsp;Add Location Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="form-group col-12" style="padding-bottom: 15px;">
													<div class="row">
														<div class="form-group col-12">
															<label class="col-form-label">Location Name</label>
															<input class="form-control" type="text" name="location_name" value="" maxlength="30" placeholder="Enter location name" required>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="insert-location" value="Save Changes">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Insert location record modal -->

						<!-- Location table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-1">#</th>
										<th>Location Name</th>
										<th class="col-2">Inventory Count</th>
										<?php if($userInfo['role_id'] == 1): ?>
											<th class="col-sm-1 col-md-2 text-center">Action</th>
										<?php else: ?>
											<th class="col-1 text-center">Action</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($locationDetails)): ?>
										<?php foreach ($locationDetails as $key => $location): ?>
										<?php $location_id = $location['location_id']; ?>
										<tr>
											<td><?php echo $key + 1 ?></td>
											<td><?php echo $location['location_name']; ?></td>
											<td><?php echo $location['inventory_count']; ?></td>

											<td>
												<center>
												<?php if($userInfo['role_id'] == 1): ?>
													<button class="btn green mb-1" id="<?php echo $location_id;?>" onclick="window.location.href='location-view.php?id=<?php echo $location_id;?>'" type="submit" name="view"  style="width: 50px; height: 37px;">
														<span data-toggle="tooltip">
															<i class="ti-search" style="font-size: 12px;"></i>
														</span>
													</button>
													<button class="btn blue mb-1" data-toggle="modal" data-target="#update-<?php echo $location_id; ?>"  style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Update">
															<i class="ti-marker-alt" style="font-size: 12px;"></i>
														</span>
													</button>
													<button class="btn red mb-1" data-toggle="modal" data-target="#delete-<?php echo $location_id; ?>" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Delete">
															<i class="ti-archive" style="font-size: 12px;"></i>
														</span>
													</button>
												<?php else: ?>
													<button class="btn green mb-1" id="<?php echo $location_id;?>" onclick="window.location.href='location-view.php?id=<?php echo $location_id;?>'" type="submit" name="view"  style="width: 50px; height: 37px;">
														<span data-toggle="tooltip">
															<i class="ti-search" style="font-size: 12px;"></i>
														</span>
													</button>
												<?php endif; ?>
												</center>
											</td>
										</tr>
										
										<!-- Update location record modal -->
										<div id="update-<?php echo $location_id; ?>" class="modal fade" role="dialog">
											<form class="update-location m-b30" method="POST" enctype="multipart/form-data">
												<div class="modal-dialog modal-md">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Update Location Record</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<input type="hidden" name="location_id" value="<?php echo $location_id ?>">
																<div class="form-group col-12" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-12">
																			<label class="col-form-label">Location Name</label>
																			<input class="form-control" type="text" name="location_name" value="<?php echo $location['location_name']; ?>" maxlength="30" required>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn green radius-xl outline" name="update-location" value="Save Changes">
															<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</form>
										</div> <!-- Update location record modal -->

										<!-- Delete location record modal -->
										<div id="delete-<?php echo $location_id; ?>" class="modal fade" role="dialog">
											<form class="delete-location m-b30" method="POST">
												<div class="modal-dialog modal-md">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Delete Record</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div><input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
														<div class="modal-body">
															<div class="row">
																<input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
																<div class="form-group col-12" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-12">
																			<label class="col-form-label">Location Name</label>
																			<input class="form-control" type="text" name="location_name" value="<?php echo $location['location_name']; ?>" readonly>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn green radius-xl outline" name="delete-location" value="Delete" onClick="return confirm('Delete This Record?')">
															<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</form>
										</div> <!-- Delete location record modal -->

										<?php endforeach; ?>
									<?php endif; ?> <!-- location table data endif -->

								</tbody>
							</table>
						</div> <!-- Location table -->

						<?php
						
							/* Insert location record controller */							
							if (isset($_POST['insert-location'])) {
								$location_name = $_POST['location_name'];

								$model->insertLocation($location_name);
								$_SESSION['successMessage'] = "New location record added successfully!";
								header("Location: location.php");
								exit();
							} 
					

							/* Update location record controller */								
							if (isset($_POST['update-location'])) {
								$location_id = $_POST['location_id'];
								$location_name = $_POST['location_name'];

								$old_values = $model->getLocationDetailsById($location_id);

								$updateLocation = $model->updateLocation($location_name, $location_id);
								$logUpdate = $model->logLocationUpdateTransaction($old_values, $newValues);
								
								$_SESSION['successMessage'] = "Location record updated successfully!";
								header("Location: location.php");
								exit();
							}

							/* Delete location record controller */						
							if (isset($_POST['delete-location'])) {
								$location_id = $_POST['location_id'];

								$model->deleteLocation($location_id);
								$_SESSION['successMessage'] = "Location record deleted successfully!";
								header("Location: location.php");
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