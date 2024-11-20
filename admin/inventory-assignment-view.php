<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	if (isset($_GET['id'])) {
		$assignment_id = $_GET['id'];
		$assignment_details = $model->getAssignmentDetailById($assignment_id);
		$assignment_items = $model->getAssignmentItemsById($assignment_id);
		$endUserId = $assignment_details['end_user_id'];
		$endUsers = $model->getEndUser();
	}
?>

<?php
	if (isset($_GET['confirm_delete']) && isset($_SESSION['confirmDelete']) && $_SESSION['confirmDelete'] === true) {
		echo '<script>
			if(confirm("All properties have been unassigned. Do you want to archive this assignment?")) {
				window.location.href = "delete-assignment.php?id=' . $_SESSION['assignment_id'] . '";
			} else {
				window.location.href = "inventory-assignment-view.php?id=' . $_SESSION['assignment_id'] . '";
			}
		</script>';
		unset($_SESSION['confirmDelete']);
		unset($_SESSION['assignment_id']);
	}
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>


	<title>Assignment Details | <?php echo $customize['sys_name']; ?></title>

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
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
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
		
		<div class="row mb-3">
			<div class="col-12 pb-2">
				<div class="d-flex justify-content-between align-items-center">
					<!-- Header aligned to the left -->
					<h2 class="p-0 mb-0">Inventory Assignment <span class="fw-normal">- Edit Properties</span></h2>

					<!-- Buttons aligned to the right, side by side -->
					<div class="d-flex gap-2">
						<!-- Add Items Button Form -->
						<form method="post" action="inventory-assignment-add.php?id=<?php echo $assignment_id ?>">
							<input type="hidden" name="assignment_id" value="<?php echo $assignment_id ?>">
							<button class="btn green radius-xl" style="background-color: #5ADA86;" id="add-items" name="add-items">
								<i class="fa fa-plus"></i>&nbsp;<span data-toggle="tooltip">ADD ITEMS</span>
							</button>
						</form>

						<!-- Edit Button Form -->
						<form method="post" action="inventory-assignment-edit.php?id=<?php echo $assignment_id ?>">
							<input type="hidden" name="assignment_id" value="<?php echo $assignment_id ?>">
							<button class="btn blue radius-xl" id="edit-items" name="edit-items">
								<i class="ti-marker-alt"></i>&nbsp;&nbsp;<span data-toggle="tooltip">EDIT</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<!-- <div id="preloader"></div> -->
					
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

						<!-- Download button -->
						<div class="row">
							<div class="col-12 d-flex justify-content-end mt-0">
								<form action="report/assignment-excel.php" method="post">
									<button class="btn blue green btn-xs radius-xl" id="assignment-excel" name="assignment-excel">
										<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
										<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>" hidden/>
										<span class="text">Download</span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
									</button>
								</form>
							</div>
						</div> <!-- Download button -->
						
						<div class="row" width="100%">
							<div class="form-group col-6">
								<label class="col-form-label">Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $assignment_details['username'] ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">Date Added</label>
								<input class="form-control" name="description" value="<?php echo date('F d, Y g:i A', strtotime($assignment_details['date_added'])); ?>" readonly>
							</div>&nbsp;
							<div class="mt-5"></div>		
							
							<!-- table -->
							<table id="assignment-table" class="table table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<th>Property No.</th>
											<th class="col-4">Description</th>
											<th>Location</th>
											<th>Unit</th>
											<th>Quantity</th>
											<th>Unit Cost</th>
											<th>Total Cost</th>
											<th>Acquisition Date</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($assignment_items)): ?>
											<?php foreach ($assignment_items as $assignment_item): ?>
											<tr>
												<td><?php echo $assignment_item['property_no']; ?></td>
												<td><?php echo $assignment_item['description']; ?></td>
												<td><?php echo $assignment_item['location']; ?></td>
												<td><?php echo $assignment_item['unit']; ?></td>
												<td><?php echo $assignment_item['qty']; ?></td>
												<td><?php echo number_format($assignment_item['unit_cost'], 2, '.', ','); ?></td>
												<td><?php echo number_format($assignment_item['total_cost'], 2, '.', ','); ?></td>
												<td><?php echo date('F d, Y', strtotime($assignment_item['acquisition_date'])); ?></td>
											</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
								
							<!-- Transfer inventory assignment modal or forms -->
							<div id="transfer-assignment" class="modal fade" role="dialog">
								<form class="transfer-assignment m-b30" method="POST" enctype="multipart/form-data">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
												<input type="hidden" name="oldEndUser" value="<?php echo $assignment_details['end_user']; ?>">
												<h4 class="modal-title">&nbsp;Property Transfer</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="form-group col-12" style="padding-bottom: 15px;">
														<div class="row">
															<div class="form-group col-12">
																<label class="col-form-label">Accountable End User</label>
																<select class="form-control" name="newEndUser" required>
																	<option value="" selected disabled hidden>-- Select End User --</option>
																	<?php if (!empty($endUsers)): ?>
																		<?php foreach ($endUsers as $endUser): ?>
																			<?php if($endUser['end_user_id'] != $endUserId): ?>
																				<option value="<?php echo $endUser['end_user_id']; ?>"><?php echo $endUser['username']; ?></option>
																			<?php endif; ?>
																		<?php endforeach; ?>
																	<?php endif; ?>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn green radius-xl outline" name="transfer-assignment" value="Next">
												<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</form>
							</div>
							
						</div> <!-- row -->
						
						<?php

							/* Insert new assignment record controller */
							if (isset($_POST['transfer-assignment'])) {
								$newEndUser = $_POST['newEndUser'];
								$oldEndUser = $_POST['oldEndUser'];
								$fromAssignmentId = $_POST['assignment_id'];
							
								// Insert the new assignment transfer record
								$newAssignmentId = $model->insertAssignmentTransfer($newEndUser, $oldEndUser);
							
								// Redirect to inventory-assignment-transfer.php with the new and old assignment IDs
								echo "<script>window.open('inventory-assignment-transfer.php?new_id=$newAssignmentId&old_id=$fromAssignmentId', '_self');</script>";
							}

							ob_end_flush(); 
							
						?>
							
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- Container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

	<!-- Insert inventory assignment modal or forms -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var tableBody = document.querySelector("#assignment-table tbody");
			var transferButton = document.getElementById("transfer-button");

			transferButton.addEventListener("click", function(event) {
				if (tableBody.rows.length === 0) {
					event.preventDefault();
					alert("Cannot transfer, the table is empty!");
				} else {
					// Manually trigger the modal if the table is not empty
					$('#transfer-assignment').modal('show');
				}
			});
		});
	</script>

</body>

</html>