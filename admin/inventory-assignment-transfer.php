<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/head-section.php') ?>

<?php
	if(!canAccessAssignment()) {
		echo "<script>alert('Access Deneid!');window.open('index', '_self');</script>";
	}
	
	if (isset($_GET['new_id']) && isset($_GET['old_id'])) {
        $newAssignmentId = $_GET['new_id'];
        $oldAssignmentId = $_GET['old_id'];
        $newAssignmentDetails = $model->getAssignmentTransferDetailById($newAssignmentId);
        $oldAssignmentDetails = $model->getAssignmentDetailById($oldAssignmentId);
		$assignment_items = $model->getAssignmentItemsById($oldAssignmentId);
		
	}
?>

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
				<?php if(canAccessInventory()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-database" aria-hidden="true"></i></span>
						<span class="ttr-label">Inventory</span>
					</a>
				</li>
				<?php endif ?>
				<?php if(canAccessAssignment()): ?>
				<li class="show" style="margin-top: 0px;">
					<a href="inventory-assignment" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>
						<span class="ttr-label">Assignment</span>
					</a>
				</li>
				<?php endif ?>
				<?php if(canAccessEndUser()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="end-user" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">End Users</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessUser() || canAccessRole()): ?>
				<li class="" style="margin-top: 0px;">
					<div class="accordion accordion-flush" id="accordionUser">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" ><i class="fa fa-user me-2 pe-3" aria-hidden="true"></i>
							User Management
							</button>
							</h2>
						<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionUser">
						<div class="accordion-body p-0">
							<?php if(canAccessUser()): ?>
							<div>
								<a href="users" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">User</span>
								</a>
							</div>
							<?php endif; ?>
							<?php if(canAccessRole()): ?>
							<div>
								<a href="roles" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">Roles</span>
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(canAccessCategory()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="category" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
						<span class="ttr-label">Categories</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessArticle()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="article" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cube" aria-hidden="true"></i></span>
						<span class="ttr-label">Article</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessLocation()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessReport()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="report.php" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
						<span class="ttr-label">Report</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessGeneralContent() || canAccessComponents() || canAccessActivityLog() || canAccessArchives()): ?>
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
				</li>
				<?php if(canAccessGeneralContent() || canAccessComponents()): ?>
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
							<?php if(canAccessGeneralContent()): ?>
							<div class="">
								<a href="system-content" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">General Content</span>
								</a>
							</div>
							<?php endif; ?>
							<?php if(canAccessComponents()): ?>
							<div class="">
								<a href="customize" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">Components</span>
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(canAccessActivityLog()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
				<?php endif; ?>
				<?php if(canAccessArchives()): ?>
				<li class="" style="margin-top: 0px;">
					<a href="archive-inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="ti-archive" aria-hidden="true"></i></span>
						<span class="ttr-label">Archives</span>
					</a>
				</li>
				<?php endif; ?>
				<?php endif; ?>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">

		<!-- Header title -->
		<div class="float-left">
			<h2 class="title-head float-left">Inventory Assignment <span style="font-weight: normal;">- Transfer Properties</span></h2>
		</div><br><br><br>
		<!-- Header title -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<!-- <div id="preloader"></div> -->
					<div class="widget-inner">
						<div class="row" width="100%">
							
							<div class="form-group col-6">
								<label class="col-form-label">From Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $newAssignmentDetails['old_username'] ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">To Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $newAssignmentDetails['new_username'] ?>" readonly>
							</div>&nbsp;
							<div class="mt-5"></div>

							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="parAddInvForm">
								<table id="table" class="table hover" style="width:100%">
									<thead>
										<tr>
											<th>Property No.</th>
											<th class="col-4">Description</th>
											<th>Location</th>
											<th>Unit</th>
											<th>Quantity</th>
											<th>Unit Cost</th>
											<th>Date Acquired</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($assignment_items)): ?>
											<?php foreach ($assignment_items as $inventory): ?>
												<?php $property_no = $inventory['property_no']; ?>
												<?php $qty_max = $inventory['qty']; ?>

												<tr>
													<td><?php echo $inventory['property_no']; ?></td>
													<td><?php echo $inventory['description']; ?></td>
													<td><?php echo !empty($inventory['location']) ? $inventory['location'] : '<span class="fw-light text-decoration-underline">Unassigned</span>'; ?></td>
													<td><?php echo $inventory['unit']; ?></td>
													<td>
														<?php if ($qty_max <= 0): ?>
															<span class="text-center p-1 radius-xl" style="font-size: 11px; color: white; background-color: red;">Assigned</span>
														<?php else: ?>
															<input style="width: 100px;" type="number" name="qty_<?php echo $property_no ?>" value="<?php echo $inventory['qty']; ?>" min="1" max="<?php echo $qty_max; ?>">
														<?php endif; ?>
													</td>
													<td><?php echo $inventory['unit_cost']; ?></td>
													<td><?php echo $inventory['acquisition_date']; ?></td>
													<td>
														<input style="height: 25px; width: 20px; margin-left: 25%;" type="checkbox" name="selected_items[]" value="<?php echo $property_no ?>">
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
								<div class="form-footer mt-4">
									<input type="hidden" name="new_assignment_id" value="<?php echo $newAssignmentId; ?>">
									<input type="hidden" name="old_assignment_id" value="<?php echo $oldAssignmentId; ?>">
									<input type="hidden" name="new_end_user" value="<?php echo $oldAssignmentId; ?>">
									<button style="float: right;" id="close_add" name="close_add" class="btn red btn-sm btn-icon-split" onClick="return confirm('Cancel?')">
										<span class="text">Close</span><span class="icon text-white-50"></span>
									</button>
									<button style="float: right;" id="save_edit" name="save_edit" class="btn green btn-sm btn-icon-split me-2">
										<span class="text">Save</span><span class="icon text-white-50"></span>
									</button>
								</div>
							</form>
				
			
							<?php 
							
							/* Insert record to inventory transfer controller */
							if (isset($_POST['save_edit'])) {
								$selectedItems = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];
								$new_assignment_id = $_POST['new_assignment_id'];
								$old_assignment_id = $_POST['old_assignment_id'];
							
								if (!empty($selectedItems)) {
									foreach ($selectedItems as $property_no) {
										$updated_qty = isset($_POST['qty_' . $property_no]) ? $_POST['qty_' . $property_no] : 0;
							
										// Fetch the property details from the old assignment
										$inventoryDetails = $model->getAssignmentItemDetails($old_assignment_id, $property_no);
							
										// Ensure we have the required details
										if ($inventoryDetails) {
											$description = $inventoryDetails['description'];
											$location = $inventoryDetails['location'];
											$unit = $inventoryDetails['unit'];
											$unit_cost = $inventoryDetails['unit_cost'];
											$acquisition_date = $inventoryDetails['acquisition_date'];
											$current_qty = $inventoryDetails['qty'];
							
											$total_cost = $unit_cost * $updated_qty;
							
											// Calculate the remaining quantity
											$remaining_qty = $current_qty - $updated_qty;
							
											if ($remaining_qty > 0) {
												// Update the old assignment with the new remaining quantity
												$model->updateAssignmentPropertyItemAfterTransfer($remaining_qty, $old_assignment_id, $property_no, $new_assignment_id);
												// Insert a new record in the new assignment
												$model->insertTransferPropertyItem($new_assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date);
											} else {
												// Remove from old assignment only if no quantity remains
												$model->removeAssignmentPropertyItem($old_assignment_id, $property_no);
												$model->insertTransferPropertyItem($new_assignment_id, $property_no, $description, $location, $unit, $current_qty, $unit_cost, $total_cost, $acquisition_date, $new_assignment_id);
											}
							
											// Update inventory Qty Physical Count in general inventory record
											$model->updateInventoryQtyPcountAfterAssigned($updated_qty, $property_no);
							
											echo "<script>alert('Inventory transferred successfully!');window.open('inventory-assignment-transfer-view.php?id=$new_assignment_id', '_self');</script>";
										} else {
											echo "<script>alert('Failed to fetch inventory details for property number: $property_no');window.open('inventory-assignment-view.php?id=$new_assignment_id', '_self');</script>";
										}
									}
								} else {
									echo "<script>alert('No selected item!');window.open('inventory-assignment-view.php?id=$new_assignment_id', '_self');</script>";
								}
							}
							
								
									
							/* Close inventory assignment transer form */
							if (isset($_POST['close_add'])) {
								$assignment_id = $_POST['new_assignment_id'];

								$model->deleteAssignmentTransfer($assignment_id);

								echo "<script>window.open('inventory-assignment', '_self');</script>";
							}
	
							?>

						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->

	<!-- bootstraps & functions -->
	<?php include('../includes/layouts/main-layouts/ttr-footer.php') ?>\

	  	<!-- Preloader -->
	  	<script>
            var loader = document.getElementById("preloader");

            window.addEventListener("load", function() {
                loader.style.display = "none";
            });
        </script>

        <!-- Data tables -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('#table').DataTable();
			});

			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>

	</body>

</html>