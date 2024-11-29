<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php

	$assignments = $model->getInventoryAssignment();
	$notes = $model->displayModuleNotes('assignment');
	$endUsers = $model->getEndUser(); 
	$inventories = $model->getAllInventory();

	// Retrieve the sum of quantity for the specified assignment_id
	$assignment_id = isset($_GET['assignment_id']) ? intval($_GET['assignment_id']) : null;
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>


	<title>Assignment | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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

		 <!-- Header and Button Row -->
		 <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Header aligned to the left -->
                    <h2 class="p-0 mb-0">Inventory Assignment</h2>

					<?php if($userInfo['role_id'] == 1): ?>
                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#insert-assignment">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD ASSIGNMENT</span>
                    </button>
					<?php endif; ?>
                </div>
            </div>
        </div>


		<div class="row">
			<div class="col-lg-12">
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

						<!-- Insert inventory assignment modal or forms-->
						<div id="insert-assignment" class="modal fade" role="dialog">
							<form class="insert-assignment m-b30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-md">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">&nbsp;Add Inventory Assignment Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="form-group col-12" style="padding-bottom: 15px;">
													<div class="row">
														<div class="form-group col-12">
																<label class="col-form-label">Accountable End User</label></br>
																<select id="end_user_select" class="form-control" name="end_user" required>
																<option value="" selected disabled hidden>-- Select End User --</option>
																<?php if (!empty($endUsers)): ?>
																	<?php foreach ($endUsers as $endUser): ?>
																		<option value="<?php echo $endUser['end_user_id']; ?>"><?php echo $endUser['username']; ?></option>
																	<?php endforeach; ?>
																<?php endif; ?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>  
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="insert-assignment" value="Next">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Insert inventory assignment modal or forms-->
						
						<!-- Inventory Assigment table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-4">End User</th>
										<th class="col-2">Inventory Count</th>
										<th class="col-1">Status</th>
										<th class="col-2">Date Added</th>
										<?php if($userInfo['role_id'] == 1): ?>
											<th class="col-sm-1 col-lg-1">Action</th>
										<?php else: ?>
											<th class="col-1">Action</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($assignments)): ?>
										<?php foreach ($assignments as $assignment): ?>
											<?php 
												$assignment_id = $assignment['assignment_id']; 
												$totalQty = $model->getAssignmentTotalQty($assignment_id);
											?>
										<tr>
											<td><?php echo $assignment['first_name'] . ' ' . $assignment['last_name']; ?></td>
											<td><?php echo $totalQty; ?></td>
											<td>	
												<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: green;">Assigned</span>		
											</td>
											<td><?php echo date('F d, Y g:i A', strtotime($assignment['date_added'])); ?></td>
											<td>
												<center>
												<?php if($userInfo['role_id'] == 1): ?>
													<button id="<?php echo $assignment_id; ?>" onclick="window.location.href='inventory-assignment-view.php?id=<?php echo $assignment_id ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="View">
															<i class="ti-search" style="font-size: 12px;"></i>
														</span>
													</button>
													<button 
														data-toggle="modal" 
														data-target="#archive-assignment<?php echo $assignment_id; ?>" 
														class="btn red mt-1" 
														style="width: 50px; height: 37px;" 
														<?php if ($totalQty > 0) echo 'disabled'; ?>
													>
														<span data-toggle="tooltip" title="Archive">
															<i class="ti-archive" style="font-size: 12px;"></i>
														</span>
													</button>
												<?php else: ?>
													<button id="<?php echo $assignment_id; ?>" onclick="window.location.href='inventory-assignment-view.php?id=<?php echo $assignment_id ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="View">
															<i class="ti-search" style="font-size: 12px;"></i>
														</span>
													</button>
												<?php endif; ?>
												</center>
											</td>
										</tr>

										<!-- Archice Assignment record modal -->
										<div id="archive-assignment<?php echo $assignment_id; ?>" class="modal fade" role="dialog">
											<form class="archive-assignment m-b30" method="POST">
												<div class="modal-dialog modal-md">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Archive Record</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
																<div class="form-group col-12" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-6">
																			<label class="col-form-label">Accountable End User</label>
																			<input class="form-control" type="text" name="end_user" value="<?php echo $assignment['username']; ?>" readonly>
																		</div>
																		<div class="form-group col-6">
																			<label class="col-form-label">Date Added</label>
																			<input class="form-control" type="text" name="end_user" value="<?php echo $assignment['date_added']; ?>" readonly>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn green radius-xl outline" name="archive-assignment" value="Archive" onClick="return confirm('Archive this record?')">
															<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</form>
										</div><!-- Archice assignment record modal -->

										<?php endforeach; ?> <!-- table data end foreach -->
									<?php endif; ?> <!-- table data endif -->

								</tbody>
							</table> <!-- table -->
						</div> <!-- table-responsive -->	

						<?php

							/* Insert new assignment record controller */
							if (isset($_POST['insert-assignment'])) {
								$endUser = $_POST['end_user'];
								
								// Insert the new assignment record
								$assignment_id = $model->insertAssignment($endUser);
							
								// Redirect to inventory-assignment-add.php with the new assignment ID
								echo "<script>window.open('inventory-assignment-create.php?id=$assignment_id', '_self');</script>";
							}

							/* Archive assignment record controller */
							if (isset($_POST['archive-assignment'])) {
								$assignment_id = $_POST['assignment_id'];

								$model->archiveAssignment($assignment_id);
								
								$_SESSION['successMessage'] = "Assignment record archived succesfully!";
								header("Location: inventory-assignment.php");
								exit();
							}

						?>		
					</div> <!-- container-fluid -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	
	<script src="../dashboard/assets/js/select2.min.js"></script>

	<script>
		$(document).ready(function() {
			// Initialize Select2 for the end user dropdown
			$('#end_user_select').select2({
				placeholder: '-- Select End User --',  // Placeholder text
				allowClear: true  // Allow clearing the selection
			});
		});
	</script>

	</body>

</html>