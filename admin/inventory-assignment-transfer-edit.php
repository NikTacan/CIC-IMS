<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/head-section.php') ?>

<?php
	if(!canAccessAssignment()) {
		echo "<script>alert('Access Deneid!');window.open('index', '_self');</script>";
	}

	if (isset($_GET['id'])) {
		$transfer_id = $_GET['id'];
		$assignment_details = $model->getAssignmentTransferDetailById($transfer_id);
		$assignment_items = $model->getTransferItemsById($transfer_id);
		$endUserId = $assignment_details['new_end_user'];
		$endUserName = $assignment_details['new_end_user_name'];
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
			<h2 class="title-head">Inventory Assignment<span style="font-weight: normal;"> - Edit properties</span></h2>
		</div> <!-- Header title -->
		<br><br><br>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div id="preloader"></div>
					<div class="widget-inner">
						<div class="row" width="100%">
							<div class="form-group col-6">
								<label class="col-form-label">Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $assignment_details['new_username'] ?>" readonly>
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
														<input class="text-center" type="number" name="qty_<?php echo $item['property_no']; ?>" value="<?php echo $item['qty']; ?>" min="1" max="<?php echo $qty_max; ?>" style="width: 60px;">
													</td>
													<td><?php echo $item['unit_cost']; ?></td>
													<td><?php echo $item['total_cost']; ?></td>
													<td><?php echo $item['acquisition_date']; ?></td>
													<td>
														<input style="height: 25px; width: 18px; margin-left: 25%;" type="checkbox" name="selected_items[]" value="<?php echo $item['property_no']; ?>" checked>
													</td>
												</tr>

											<?php endforeach; ?>
										<?php endif; ?>
										
									</tbody>			
								</table>

								<div class="form-footer mt-4">
									<input type="hidden" name="transfer_id" value="<?php echo $transfer_id; ?>">
									<input type="hidden" name="end_user" value="<?php echo $endUserId; ?>">
									<input type="hidden" name="end_user_name" value="<?php echo $endUserName; ?>">
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
									$transfer_id = $_POST['transfer_id'];
									$endUserId = $_POST['end_user'];
									$endUserName = $_POST['end_user_name'];
									$selectedItems = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];

									$transferIDItems = $model->getInventoryTransferPropertyItems($transfer_id); 

									foreach ($transferIDItems as $row) {
										$property_no = $row['property_no'];
										$description = $row['description'];
										$qty = $row['qty'];
										$location = $row['location'];
	
										$newQty = isset($_POST['qty_' . $property_no]) ? intval($_POST['qty_' . $property_no]) : 0;

										// Check if location post is location post, else set empty
										$newLocation = isset($_POST['location_' . $property_no]) ? $_POST['location_' . $property_no] : '';

										
										if (!isset($_POST['selected_items']) || !in_array($property_no, $_POST['selected_items'])) {
											
											$model->addInventoryQtyPcountFromAssignment($property_no, $qty, $transfer_id);
											$model->deleteAssignmentTransfertItems($property_no, $transfer_id, $description);
										}
	
										if ($newQty < $qty) {
											$difference = $qty - $newQty;
											
											$model->updateAssignmentTransferItemsQty($transfer_id, $property_no, $newQty, $qty);
											$model->addInventoryQtyPcountFromAssignmentTransfer($property_no, $difference, $transfer_id, $endUserName);
										}

										if($newLocation != $location) {

											$model->updateAssignmentTransferItemLocation($transfer_id, $property_no, $newLocation, $location, $description, $endUserId);	
										}

										
									}
									echo "<script>alert('Updated Successfully!');window.open('inventory-assignment-transfer-view.php?id=$transfer_id', '_self');</script>";
								}						

								/* Close inventory transfer edit controller */
								if (isset($_POST['close_edit'])) {
									$transfer_id = $_POST['transfer_id'];
									
									echo "<script>window.open('inventory-assignment-transfer-view.php?id=$transfer_id', '_self');</script>";
								}

							?>

						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box-->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->

<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/footer.php') ?>