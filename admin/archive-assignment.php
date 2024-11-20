<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>
<?php include('../includes/explode-data.php'); ?>

<?php
	$assignmentArchives = $model->getAssignmentArchives();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Assignment Archives | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
                    <h2 class="p-0 mb-0">Inventory Assignment Archive</h2>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12 m-b30">

				<!-- navigation tabs -->
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link" href="archive-inventory">Inventory</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="archive-assignment">Assignment</a>
					</li>
				</ul> <!-- navigation tabs -->
			
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
						
						<!-- Main table -->
						<table id="table" class="table" style="width:100%">
							<thead>
								<tr>
									<th class="col-5">End User</th>
									<th class="col-2">Date Assigned</th>
									<th class="col-2">Date Archived</th>
									<th class="col-1">Action</th>
								</tr>
							</thead>
							<tbody>
								
								<?php if(!empty($assignmentArchives)): ?>
									<?php foreach ($assignmentArchives as $archiveInfo): ?>
										<?php $archive_id = $archiveInfo['id']; ?>
										<?php $assignment_id = $archiveInfo['assignment_id']; ?>
										<tr>
											<td><?php echo getNameFromField($archiveInfo['end_user']); ?></td>
											<td><?php echo $archiveInfo['date_added']; ?></td>
											<td><?php echo $archiveInfo['date_archived']; ?></td>
											
											<td>
												<center>
													<button data-toggle="modal" data-target="#restore-<?php echo $archive_id; ?>" class="btn green" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Restore">
															<i class="ti-reload" style="font-size: 12px;"></i>
														</span>
													</button>
													<button data-toggle="modal" data-target="#delete-<?php echo $archive_id; ?>" class="btn red" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Delete">
															<i class="ti-archive" style="font-size: 12px;"></i>
														</span>
													</button>
												</center>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?> <!-- assignment archive endif -->

							</tbody>
						</table> <!-- Main table -->			

						<!-- View assignment archive record -->
						<?php if(!empty($assignmentArchives)): ?>
							<?php foreach ($assignmentArchives as $archiveDetail): ?>
								<?php $archive_id = $archiveDetail['id']; ?>
								<?php $assignment_id = $archiveDetail['assignment_id']; ?>
								<?php $end_user = $archiveDetail['end_user']; ?>

									<!-- Restore inventory assignment archive record modal -->
									<div id="restore-<?php echo $archive_id; ?>" class="modal fade" role="dialog">
										<form class="edit-profile m-b30" method="POST">
											<div class="modal-dialog modal-xl">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Review Record</h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div>
													<input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
													<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
													<div class="modal-body">
														<div class="row">
															<input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
															<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
															<div class="form-group col-12">
																<div class="row">
																	<div class="form-group col-6">
																		<label class="col-form-label">Accountable End User</label>
																		<input class="form-control" type="text" name="end_user_name" value="<?php echo getNameFromField($archiveDetail['end_user']); ?>" readonly>
																		<input type="hidden" name="end_user" value="<?php echo $archiveDetail['end_user']; ?>">
																	</div>
																	<div class="form-group col-6">
																		<label class="col-form-label">Date Added</label>
																		<input class="form-control" name="date_added" value="<?php echo date('Y-m-d', strtotime($archiveDetail['date_added'])); ?>" readonly>
																	</div>
																	<div class="form-group col-6">
																	</div>
																	<div class="form-group col-6">
																		<label class="col-form-label">Date Archived</label>
																		<input class="form-control" type="date" name="date_archived" value="<?php echo date('Y-m-d', strtotime($archiveDetail['date_archived'])); ?>" readonly>
																	</div>
																	<div style="padding: 25px;"></div>

																	<!-- Assigned property items table -->
																	<div class="form-group col-12">
																		<div >
																			<table class="table table-striped table-hover" style="width:100%">
																				<thead class="table">
																					<tr>
																						<th class="col-2">Property No.</th>
																						<th>Description</th>
																						<th>Unity</th>
																						<th>Quantity</th>
																						<th>Unit Cost</th>
																						<th>Total Cost</th>
																						<th>Date Acquired</th>
																					</tr>
																				</thead>
																				<tbody class="table">
																					<?php if(!empty($assignmentItems = $model->getAssignmentItemsArchives($assignment_id))): ?>
																						<?php foreach ($assignmentItems as $assignmentItem): ?>
																							<tr>
																								<td><?php echo $assignmentItem['property_no']; ?></td>
																								<td><?php echo $assignmentItem['description']; ?></td>
																								<td><?php echo $assignmentItem['unit']; ?></td>
																								<td><?php echo $assignmentItem['qty']; ?></td>
																								<td><?php echo $assignmentItem['unit_cost']; ?></td>
																								<td><?php echo $assignmentItem['total_cost']; ?></td>
																								<td><?php echo date('M d, Y', strtotime($assignmentItem['acquisition_date'])); ?></td>
																							</tr>
																							<?php endforeach; ?>
																						<?php endif; ?>
																					</tbody>	
																			</table>
																		</div>
																	</div> <!-- Assigned property items table -->

																</div> <!-- row -->
															</div> <!-- form-group -->
														</div> <!-- row -->
													</div>
													<div class="modal-footer">
														<input type="submit" class="btn green radius-xl outline" name="restore-assignment" value="Restore" onClick="return confirm('Restore This Record?')">
														<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
													</div>
												</div> <!-- modal-content -->
											</div> <!-- modal-dialouge -->
										</form>
									</div>	<!-- Restore inventory assignment archive record modal -->

									<!-- Delete inventory assignment archive record modal -->
									<div id="delete-<?php echo $archive_id; ?>" class="modal fade" role="dialog">
										<form class="delete-archive m-b30" method="POST">
											<div class="modal-dialog modal-xl">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Delete Record</h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div>
													<div class="modal-body">
														<div class="row">
															<input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
															<input type="hidden" name="end_user" value="<?php echo $end_user; ?>">
															<div class="form-group col-12">
																<div class="row">
																	<div class="form-group col-6">
																		<label class="col-form-label">Accountable End User</label>
																		<input class="form-control" name="end_user" value="<?php echo getNameFromField($archiveDetail['end_user']); ?>" readonly>
																	</div>
																	<div class="form-group col-6">
																		<label class="col-form-label">Date Added</label>
																		<input class="form-control" name="description" value="<?php echo date('F d, Y', strtotime($archiveDetail['date_added'])); ?>" readonly>
																	</div>
																	<div class="form-group col-6">
																	</div>
																	<div class="form-group col-6">
																		<label class="col-form-label">Date Archived</label>
																		<input class="form-control" type="date" name="date_archived" value="<?php echo $formattedDate = date('Y-m-d', strtotime($archiveDetail['date_archived'])); ?>" readonly>
																	</div>
																	<div style="padding: 25px;"></div>\

																	<!-- Assigned property items table -->
																	<div class="form-group col-12">
																		<div >
																			<table class="table table-striped table-hover"style="width:100%">
																				<thead class="table">
																					<tr>
																						<th class="col-2">Property No.</th>
																						<th>Description</th>
																						<th>Unity</th>
																						<th>Quantity</th>
																						<th>Unit Cost</th>
																						<th>Total Cost</th>
																						<th>Date Acquired</th>
																					</tr>
																				</thead>
																				<tbody class="table">
																					<?php if(!empty($assignmentItems = $model->getAssignmentItemsArchives($assignment_id))): ?>
																						<?php foreach ($assignmentItems as $assignmentItem): ?>
																						<tr>
																							<td><?php echo $assignmentItem['property_no']; ?></td>
																							<td><?php echo $assignmentItem['description']; ?></td>
																							<td><?php echo $assignmentItem['unit']; ?></td>
																							<td><?php echo $assignmentItem['qty']; ?></td>
																							<td><?php echo $assignmentItem['unit_cost']; ?></td>
																							<td><?php echo $assignmentItem['total_cost']; ?></td>
																							<td><?php echo date('M d, Y', strtotime($assignmentItem['acquisition_date'])); ?></td>
																						</tr>
																						<?php endforeach; ?>
																					<?php endif; ?>
																				</tbody>	
																			</table>
																		</div>
																	</div> <!-- Assigned property items table -->

																</div> <!-- row -->
															</div> <!--form-group -->
														</div> <!-- row -->
													</div> <!-- modal-body -->
													<div class="modal-footer">
														<input type="submit" class="btn red radius-xl outline" name="delete-archive" value="Delete" onClick="return confirm('Restore This Record?')">
														<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
													</div>
												</div> <!-- modal-content -->
											</div> <!-- modal-dialouge -->
										</form>
									</div>	<!-- Delete inventory assignment archive record modal -->

							<?php endforeach; ?>
						<?php endif; ?> <!-- View assignment archive record -->

						<?php

							/* Restore inventory assignment archive record controller */
							if (isset($_POST['restore-assignment'])) {
								$assignment_id = $_POST['assignment_id'];
								$archive_id = $_POST['archive_id'];
								$end_user = getNumberFromField($_POST['end_user']);
								$date_added = $_POST['date_added'];
								$date_archived = $_POST['date_archived'];

								$checkId = $model->checkAssignmentIdExist($assignment_id);

								if (!$checkId) {

									$restoreAssignment = $model->restoreAssignment($assignment_id, $end_user, $date_added, $archive_id);
									$logRestore = $model->logAssignmentRestoreTransaction($assignment_id, $end_user, $date_archived);

									echo "<script>alert('$end_user inventory assignment record has been restored!');window.open('archive-assignment', '_self')</script>";

									$_SESSION['successMessage'] = "Inventory archived record restored successfully!";
									header("Location: archive-assignment.php");
									exit();
								} else {
									$_SESSION['errorMessage'] = "Record ID already exists in assignment records!";
									header("Location: archive-assignment.php");
									exit();
								}
							}

							/* Delete inventory assignment archive record controller */
							if (isset($_POST['delete-archive'])) {
								$archive_id = $_POST['archive_id'];
								$end_user = $_POST['end_user'];

								$deleteAssignmentArchive = $model->deleteAssignmentArchive($archive_id, $end_user);	

								$_SESSION['successMessage'] = "Assignment archive record has been deleted!";
								header("Location: archive-assignment.php");
								exit();
							}

							ob_end_flush();

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
