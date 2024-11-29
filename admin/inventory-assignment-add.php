<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	
	if (isset($_GET['id'])) {
	$assignment_id = $_GET['id'];
	$assignment_details = $model->getAssignmentDetailById($assignment_id);
	$inventories = $model->getAllInventory();

	$endUsername = $assignment_details['username'];
	$endUserId = $assignment_details['end_user_id'];
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

		<!-- Header title -->
		<div class="float-left">
			<h2 class="title-head float-left">Inventory Assignment <span style="font-weight: normal;">- Assign Properties</span></h2>
		</div><br><br><br>
		<!-- Header title -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="widget-inner">
						<div class="row" width="100%">
							<div class="form-group col-6">
								<label class="col-form-label">Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $endUsername ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">Date Added</label>
								<input class="form-control" name="description" value="<?php echo date('F d, Y g:i A', strtotime($assignment_details['date_added'])); ?>" readonly>
							</div>&nbsp;
							<div class="mt-5"></div>

							<form action = "<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" id="parAddInvForm">			
								<table id="table" class="table hover" style="width:100%">
									<thead>
										<tr>
											<th>Property No.</th>
											<th class="col-4">Description</th>
											<th>Remark</th>
											<th>Location</th>
											<th>Unit</th>
											<th>Quantity</th>
											<th>Unit Cost</th>
											<th>Date Acquired</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($inventories)): ?>
											<?php foreach ($inventories as $inventory): ?>
												<?php $inv_id = $inventory['inv_id']; ?>
												<?php $qty_max = $inventory['qty_pcount']; ?>

												<tr>
													<td><?php echo $inventory['property_no']; ?></td>
													<td><?php echo $inventory['description']; ?></td>
													<td>
													<?php if(!empty($invNotes = $model->displayInvNotes('inventory', $inventory['remark_name']))): ?>
														<?php foreach ($invNotes as $invNote): ?>
															<span style="font-size: 12px; color: white; padding: 4px; border-radius: 25px; background-color: <?php echo $invNote['color']; ?>;"><?php echo $invNote['note_name']; ?></span>
														<?php endforeach; ?>
													<?php endif; ?>
													</td>
													<td><?php echo !empty($inventory['location_name']) ? $inventory['location_name'] : '<span class="fw-light text-decoration-underline">Unassigned</span>'; ?></td>
													<td><?php echo $inventory['unit_name']; ?></td>
													<td>
														<?php if ($qty_max <= 0): ?>
															<span class="text-center p-1 radius-xl" style="font-size: 11px; color: white; background-color: red;">Assigned</span>
														<?php else: ?>
															<input style="width: 100px;" type="number" name="qty_<?php echo $inv_id ?>" value="<?php echo $inventory['qty_pcount']; ?>" min="1" max="<?php echo $qty_max; ?>">
														<?php endif; ?>
													</td>
													<td><?php echo $inventory['unit_cost']; ?></td>
													<td><?php echo $inventory['acquisition_date']; ?></td>
													<td>
													<?php if($inventory['remark_name'] != 'Unserviceable' && $qty_max > 0): ?>
														<input style="height: 25px; width: 20px; margin-left: 25%;" type="checkbox" name="selected_items[]" value="<?php echo $inv_id ?>">
													<?php endif; ?>
												</td>
												</tr>

											<?php endforeach; ?>
										<?php endif; ?>			

									</tbody>			
								</table>

								<div class="form-footer mt-4">
									<input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
									<input type="hidden" name="endUsername" value="<?php echo $endUsername; ?>">
									<input type="hidden" name="endUserId" value="<?php echo $endUserId; ?>">
									<button style="float: right;" id="close_add" name="close_add" class="btn red btn-sm btn-icon-split">
										<span class="text">Cancel</span><span class="icon text-white-50"></span>
									</button>
									<button style="float: right;" id="save_edit" name="save_edit" class="btn green btn-sm btn-icon-split me-2">
										<span class="text">Save</span><span class="icon text-white-50"></span>
									</button>
								</div>
							</form>
				
			
							<?php 

								/* Add or update assigning properties controller */
								if (isset($_POST['save_edit'])) {
									$selectedItems = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];
									$assignment_id = $_POST['assignment_id'];
									$endUsername = $_POST['endUsername'];
									$endUserId = $_POST['endUserId'];
								
									if (!empty($selectedItems)) {
										foreach ($selectedItems as $inv_id) {
											$updated_qty = isset($_POST['qty_' . $inv_id]) ? $_POST['qty_' . $inv_id] : 0;
								
											// Fetch the selected Inventory's details
											$result = $model->getInventoryDetailsByInvId($inv_id);
								
											if (!empty($result)) {
												foreach ($result as $row) {
													// Extract the details from the selected inventories
													$property_no = $row['property_no'];
													$description = $row['description'];
													$location = $row['location_name'];
													$unit = $row['unit_name'];
													$current_qty = $row['qty_pcount']; // Get the current quantity
													$unit_cost = $row['unit_cost'];
													$acquisition_date = $row['acquisition_date'];
								
													$updated_qtyPcount = $current_qty - $updated_qty;
													$total_cost = $updated_qty * $unit_cost;
								
													// Check if the checked property item is already in assignment
													$assignmentItemStatus = $model->checkAssignmentItemStatus($assignment_id, $property_no);
								
													if ($assignmentItemStatus > 0) {
														// If the property exists, update the quantity
														$model->updateAssignmentPropertyItem($location, $updated_qty, $total_cost, $assignment_id, $property_no, $endUsername, $description, $unit,$endUserId);
								
														// Update inventory Qty Physical Count in general inventory record
														$model->updateInventoryQtyPcountAfterAssigned($updated_qtyPcount, $property_no);
								
														$_SESSION['successMessage'] = "Property item added successfully!";
														header("Location: inventory-assignment-view.php?id=$assignment_id");
								
													} else {
														// If the asset does not exist, insert a new record
														$model->insertAssignmentPropertyItem($assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date, $endUsername, $endUserId);
														$model->updateInventoryQtyPcountAfterAssigned($updated_qtyPcount, $property_no);
								
														$_SESSION['successMessage'] = "Property item added successfully!";
														header("Location: inventory-assignment-view.php?id=$assignment_id");
													}
												}
											} else {
												$_SESSION['errorMessage'] = "Adding property unsuccesful!";
												header("Location: inventory-assignment-view.php?id=$assignment_id");
											}
										}
									} else {
										$_SESSION['errorMessage'] = "No selected item!";
										header("Location: inventory-assignment-view.php?id=$assignment_id");
									}
								}
								
								
								/* Close form */
								if (isset($_POST['close_add'])) {
									$assignment_id = $_POST['assignment_id'];

									header("Location: inventory-assignment-view.php?id=$assignment_id");
								}

							?>

						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
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