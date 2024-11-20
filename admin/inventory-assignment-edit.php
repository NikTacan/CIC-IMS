<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	if (isset($_GET['id'])) {
		$assignment_id = $_GET['id'];
		$assignment_details = $model->getAssignmentDetailById($assignment_id);
		$assignment_items = $model->getAssignmentPropertyItems($assignment_id);
	}
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
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div id="preloader"></div>
					<div class="widget-inner">
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

							<!-- Table -->
							<form action = "<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" id="parAddInvForm">
							<input type="hidden" name="par_id" value="<?php echo $par_id; ?>">	
								<table id="table" class="table hover" style="width:100%">
									<thead>
										<tr>
											<th>Property No.</th>
											<th>Description</th>
											<th>Location</th>
											<th>Unit</th>
											<th>Quantity</th>
											<th>Unit Cost (₱)</th>
											<th>Total Amount (₱)</th>
											<th>Date Acquired</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

										<?php if (!empty($assignment_items)): ?>
											<?php foreach ($assignment_items as $item): ?>	
												<?php $qty_max = $item['qty']; ?>
												<tr>
													<td><?php echo $item['property_no']; ?></td>
													<td><?php echo $item['description']; ?></td>
													<td>
														<input type="text" value="<?php echo $item['location']; ?>" name="location_<?php echo $item['property_no']; ?>">
													</td>
													<td><?php echo $item['unit']; ?></td>
													<td class="col-1"> 
														<input class="text-center" type="number" name="qty_<?php echo $item['property_no']; ?>" value="<?php echo $item['qty']; ?>" min="0" max="<?php echo $qty_max; ?>" style="width: 60px;">
													</td>
													<td><?php echo $item['unit_cost']; ?></td>
													<td><?php echo $item['total_cost']; ?></td>
													<td><?php echo date('F d, Y', strtotime($item['acquisition_date'])); ?></td>
													<td>
														<input style="height: 25px; width: 18px; margin-left: 25%;" type="checkbox" name="selected_items[]" value="<?php echo $item['property_no']; ?>" checked>
													</td>
												</tr>

											<?php endforeach; ?>
										<?php endif; ?>
										
									</tbody>			
								</table>

								<div class="form-footer mt-4">
									<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
									<button style="float: right;" id="close_edit" name="close_edit" class="btn red btn-sm btn-icon-split">
										<span class="text">Close</span><span class="icon text-white-50"></span>
									</button>
									<button style="float: right;" id="save_edit" name="save_edit" class="btn green btn-sm btn-icon-split me-2">
										<span class="text">Save</span><span class="icon text-white-50"></span>
									</button>
								</div>
							</form> <!-- Table -->
							
							
							<?php 

								/* Edit or remove Property items controller */
								if (isset($_POST['save_edit'])) {
									$assignment_id = $_POST['assignment_id'];
									$selectedItems = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];
								
									$assignmentId_items = $model->getAssignmentPropertyItems($assignment_id); 
									$itemsToDelete = 0;
								
									foreach ($assignmentId_items as $row) {
										$property_no = $row['property_no'];
										$qty = $row['qty'];
										$location = $row['location'];
								
										$newQty = isset($_POST['qty_' . $property_no]) ? intval($_POST['qty_' . $property_no]) : 0;
								
										// Check if location post is location post, else set empty
										$newLocation = isset($_POST['location_' . $property_no]) ? $_POST['location_' . $property_no] : '';
								
										if (!isset($_POST['selected_items']) || !in_array($property_no, $_POST['selected_items'])) {
											$model->addInventoryQtyPcountFromAssignment($property_no, $qty, $assignment_id);
											$model->deleteAssignmentItems($property_no, $assignment_id);
											$itemsToDelete++;
										}
								
										if ($newQty < $qty) {
											$difference = $qty - $newQty;
											
											$model->updateAssignmentItemsQty($assignment_id, $property_no, $newQty, $qty);
											$model->addInventoryQtyPcountFromAssignment($property_no, $difference, $assignment_id);
										}
								
										if($newLocation != $location) {
											$model->updateAssignmentItemsLocation($assignment_id, $property_no, $newLocation, $location);    
										}
									}
								
									// Check if all items are deleted
									if ($itemsToDelete == count($assignmentId_items)) {
										$_SESSION['confirmDelete'] = true;
										$_SESSION['assignment_id'] = $assignment_id;
										header("Location: inventory-assignment-view.php?id=$assignment_id&confirm_delete=1");
										exit();
									}
								
									$_SESSION['successMessage'] = "Updated successfully!";
									header("Location: inventory-assignment-view.php?id=$assignment_id");
									exit();
								}					

								/* Close inventory assignment edit controller */
								if (isset($_POST['close_edit'])) {
									$assignment_id = $_POST['assignment_id'];
									
									header("Location: inventory-assignment-view.php?id=$assignment_id");
								}

							?>

						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box-->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	<?php include('../includes/js/preloader.php'); ?>

</body>
</html>
