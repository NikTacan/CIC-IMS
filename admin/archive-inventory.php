<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>
<?php include('../includes/explode-data.php'); ?>

<?php
	$inventories = $model->getInventoryArchives();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Inventory Archives | <?php echo $customize['sys_name']; ?></title>

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
                    <h2 class="p-0 mb-0">Inventory Archive</h2>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12 m-b30">

				<!-- assignment nav --> 
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page"  href="archive-inventory">Inventory</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="archive-assignment">Assignment</a>
					</li>
				</ul>

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
						
						<div class="table-responsive">
						<!-- Table -->
						<table id="table" class="table" style="width:100%">
							<thead>
								<tr>
									<th class="col-2">Property No</th>
									<th class="col-3">Description</th>
									<th class="col-2">Article</th>
									<th class="col-2">Date Archived</th>
									<th class="col-sm-1 col-lg-2">Action</th>
								</tr>
							</thead>
							<tbody>
								
								<?php if(!empty($inventories)): ?>
									<?php foreach ($inventories as $inventory): ?>
										<?php $archive_id = $inventory['id']; ?>
										<?php $inv_id = $inventory['inv_id']; ?>
										<tr>
											<td><?php echo $inventory['property_no']; ?></td>
											<td><?php echo $inventory['description']; ?></td>
											<td><?php echo getNameFromField($inventory['article']); ?></td>
											
											<td><?php echo $inventory['date_archived']; ?></td>
											<td>
												<center>
													<button data-toggle="modal" data-target="#restore-<?php echo $archive_id; ?>" class="btn green mt-1" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Restore">
															<i class="ti-reload" style="font-size: 12px;"></i>
														</span>
													</button>
													<button data-toggle="modal" data-target="#delete-<?php echo $archive_id; ?>" class="btn red mt-1" style="width: 50px; height: 37px;">
														<span data-toggle="tooltip" title="Delete">
															<i class="ti-archive" style="font-size: 12px;"></i>
														</span>
													</button>
												</center>
											</td>
										</tr>
										
										<!-- Review inventory record to restore modal -->	
										<div id="restore-<?php echo $archive_id; ?>" class="modal fade" role="dialog">
											<form class="edit-profile m-b30" method="POST">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Restore Record</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div><input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
														<input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
														<div class="modal-body">
															<div class="row">
																<input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
																<input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
																<input type="hidden" name="archive_date" value="<?php echo $inventory['date_archived']; ?>">
																<div class="form-group col-6" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-12"> 
																			<label class="col-form-label">Property No.</label>
																			<div class="input-group">
																				<input class="form-control property-no-input" type="text" name="property_no" value="<?php echo $inventory['property_no']; ?>" readonly>
																				<div class="input-group-append">
																					<button class="btn blue edit-btn" type="button" onclick="toggleEditPropertyNo(this)">
																						<span data-toggle="tooltip">
																							<i class="ti-marker-alt" style="font-size: 12px;"></i>
																						</span>
																					</button>
																				</div>
																			</div>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Description</label>
																			<textarea class="form-control" name="description" readonly><?php echo $inventory['description']; ?></textarea>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Article</label>
																			<input class="form-control" type="text" name="article_name" value="<?php echo getNameFromField($inventory['article']); ?>" readonly>
																			<input type="hidden" name="article" value="<?php echo $inventory['article']; ?>">
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Acquisition Date</label>
																			<input class="form-control" type="date" name="acquired_date" value="<?php echo $formattedDate = date('Y-m-d', strtotime($inventory['acquisition_date'])); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Remarks</label>
																			<input class="form-control" type="text" name="remark_name" value="<?php echo getNameFromField($inventory['remark']); ?>" readonly>
																			<input type="hidden" name="remark" value="<?php echo $inventory['remark']; ?>">
																		</div>
																	</div>
																</div>
																<div class="form-group col-6" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-12">
																			<label class="col-form-label">Category</label>
																			<input class="form-control" type="text" name="category_name" value="<?php echo getNameFromField($inventory['category']); ?>" readonly>
																			<input type="hidden" name="category" value="<?php echo $inventory['category']; ?>">
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Location</label>
																			<input class="form-control" type="text" name="location_name" value="<?php echo getNameFromField($inventory['location']); ?>" readonly>
																			<input type="hidden" name="location" value="<?php echo $inventory['location']; ?>">
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Unit</label>
																			<input class="form-control" type="text" name="unit_name" value="<?php echo getNameFromField($inventory['unit']); ?>" readonly>
																			<input type="hidden" name="unit" value="<?php echo $inventory['unit']; ?>">
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Qty per Property Card:</label>
																			<input class="form-control" type="number" name="qty_pcard" id="qty_pcard" value="<?php echo $inventory['qty_pcard']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Qty per Physical Count:</label>
																			<input class="form-control" type="number" name="qty_pcount" id="qty_pcount" value="<?php echo $inventory['qty_pcount']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Unit Cost (₱) :</label>
																			<input class="form-control" type="number"  step="0.01" name="cost" id="cost" value="<?php echo $inventory['unit_cost']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Estimated Useful Life</label>
																			<input class="form-control" type="text" name="estlife_name" value="<?php echo getNameFromField($inventory['est_life']); ?>" readonly>
																			<input type="hidden" name="est_life" value="<?php echo $inventory['est_life']; ?>">
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn green radius-xl outline" name="restore-inventory" value="Restore" onClick="return confirm('Restore This Record?')">
															<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</form>
										</div>	<!-- Review inventory archive record to restore modal -->			

									
										<!-- Delete inventory archive record modal -->	
										<div id="delete-<?php echo $archive_id; ?>" class="modal fade" role="dialog">
											<form class="edit-profile m-b30" method="POST">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Delete Record</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div><input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
														<div class="modal-body">
															<div class="row">
																<input type="hidden" name="archive_id" value="<?php echo $archive_id; ?>">
																<div class="form-group col-6" style="padding-bottom: 15px;">
																	<div class="row">
	
																		<div class="form-group col-12">
																			<label class="col-form-label">Property No.</label>
																			<input class="form-control" type="text" name="property_no" value="<?php echo $inventory['property_no']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Description</label>
																			<textarea class="form-control" name="description" readonly><?php echo $inventory['description']; ?></textarea>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Article</label>
																			<input class="form-control" type="text" name="article" value="<?php echo getNameFromField($inventory['article']); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Acquisition Date</label>
																			<input class="form-control" type="date" name="acquired_date" value="<?php echo $formattedDate = date('Y-m-d', strtotime($inventory['acquisition_date'])); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Remarks</label>
																			<input class="form-control" type="text" name="remark" value="<?php echo getNameFromField($inventory['remark']); ?>" readonly>
																		</div>
																	</div>
																</div>
																<div class="form-group col-6" style="padding-bottom: 15px;">
																	<div class="row">
																		<div class="form-group col-12">
																			<label class="col-form-label">Category</label>
																			<input class="form-control" type="text" name="category" value="<?php echo getNameFromField($inventory['category']); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Location</label>
																			<input class="form-control" type="text" name="location" value="<?php echo getNameFromField($inventory['location']); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Unit</label>
																			<input class="form-control" type="text" name="unit" value="<?php echo getNameFromField($inventory['unit']); ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Qty per Property Card:</label>
																			<input class="form-control" type="number" name="qty_pcard" id="qty_pcard" value="<?php echo $inventory['qty_pcard']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Qty per Physical Count:</label>
																			<input class="form-control" type="number" name="qty_pcount" id="qty_pcount" value="<?php echo $inventory['qty_pcount']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Unit Cost (₱) :</label>
																			<input class="form-control" type="number"  step="0.01" name="cost" id="cost" value="<?php echo $inventory['unit_cost']; ?>" readonly>
																		</div>
																		<div class="form-group col-12">
																			<label class="col-form-label">Estimated Useful Life</label>
																			<input class="form-control" type="text" name="est_life" value="<?php echo getNameFromField($inventory['est_life']); ?>" readonly>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" class="btn green radius-xl outline" name="delete-inventory" value="Delete" onClick="return confirm('This will be permanently deleted from the database. Are you want to delete this record?')">
															<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</form>
										</div>	<!-- Delete inventory archive record modal -->		

									<?php endforeach; ?>
								<?php endif; ?> <!-- archived inventory data table endif -->

							</tbody>
						</table>
						</div>

						<?php

						/* Restore inventory record from archive controller */
						if (isset($_POST['restore-inventory'])) {
							$inv_id = $_POST['inv_id'];
							$property_no = $_POST['property_no'];
							$article = getNumberFromField($_POST['article']);
							$acquired_date = $_POST['acquired_date'];
							$description = $_POST['description'];
							$category = getNumberFromField($_POST['category']);
							$location = getNumberFromField($_POST['location']);
							$unit = getNumberFromField($_POST['unit']);
							$qty_pcard = $_POST['qty_pcard'];
							$qty_pcount = $_POST['qty_pcount'];
							$cost = $_POST['cost'];
							$est_life = getNumberFromField($_POST['est_life']);
							$remark = getNumberFromField($_POST['remark']);
							$date_archived = $_POST['archive_date'];
							
							$propertyExist = $model->checkPropertyNoExist($property_no);
							
							if(empty($propertyExist)) {
								$model->insertInventory($property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark);

								$logRestore = $model->logInventoryRestoreTransaction($inv_id, $description, $date_archived);

								$model->deleteArchive($archive_id, $inv_id);
							
								$_SESSION['successMessage'] = "Inventory record restored successfully!";
								header("Location: archive-inventory.php");
								exit();
							} else {
								$_SESSION['errorMessage'] = "Property no. already exist!";
								header("Location: archive-inventory.php");
								exit();
							}
						}

						/* Delete inventory record from archive controller */
						if (isset($_POST['delete-inventory'])) {
							$inv_id = $_POST['inv_id'];
							$model->deleteArchive($archive_id, $inv_id);	
							
							$_SESSION['successMessage'] = "Archived inventory record deleted successfully!";
							header("Location: archive-inventory.php");
							exit();
						}

						?>
							
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main>
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

	<script>
		function toggleEditPropertyNo(button) {
			// Get the input field for "Property No."
			const inputField = button.closest('.input-group').querySelector('.property-no-input');
			
			// Check if the field is currently readonly
			if (inputField.hasAttribute('readonly')) {
				// Remove readonly to enable editing
				inputField.removeAttribute('readonly');
				inputField.focus();  // Optional: focus the input for immediate editing
				button.classList.replace('blue', 'green'); // Change button color to indicate editing mode
			} else {
				// Re-add readonly to disable editing
				inputField.setAttribute('readonly', true);
				button.classList.replace('green', 'blue'); // Revert button color after editing
			}
		}
	</script>

</body>
</html>