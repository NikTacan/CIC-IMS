<?php include('../includes/session.php'); ?>

<?php 
	$locationDetails = $model->getLocationDetailsByEndUser($end_user_id);
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
				<li class="show" style="margin-top: 0px;">
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid" style="margin-right: 50%;">

		<div class="ttr-container-header row col-lg-12 mb-3">
			<div class="d-flex justify-content-between mx-0 px-0">
				<div class="float-left">
					<h2 class="p-0 ms-2 mb-0">Location</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="widget-inner">
						
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
										<th class="col-sm-1 col-lg-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($locationDetails)): ?>
										<?php foreach ($locationDetails as $key => $location): ?>
										<tr>
											<td><?php echo $key + 1 ?></td>
											<td><?php echo $location['location_name']; ?></td>
											<td><?php echo $location['inventory_count']; ?></td>

											<td>
												<center>
												<button class="btn green" onclick="window.location.href='location-view.php?location=<?php echo $location['location_name'];?>'" type="button" name="view" style="width: 50px; height: 37px;">
													<span data-toggle="tooltip">
														<i class="ti-search" style="font-size: 12px;"></i>
													</span>
												</button>
												</center>
											</td>
										</tr>
										
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
								echo "<script>alert('Location has been added!');window.open('location', '_self')</script>";
							} 
					

							/* Update location record controller */								
							if (isset($_POST['update-location'])) {
								$location_id = $_POST['location_id'];
								$location_name = $_POST['location_name'];

								$old_values = $model->getLocationDetailsById($location_id);

								$updateLocation = $model->updateLocation($location_name, $location_id);
								$logUpdate = $model->logLocationUpdateTransaction($old_values, $newValues);
								
								echo "<script>alert('Location has been updated!');window.open('location', '_self')</script>";
							}

							/* Delete location record controller */						
							if (isset($_POST['delete-location'])) {
								$location_id = $_POST['location_id'];

								$model->deleteLocation($location_id);
								echo "<script>alert('Location record has been deleted!');window.open('location', '_self')</script>";
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