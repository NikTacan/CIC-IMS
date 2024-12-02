<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	$inventories = $model->getAllInventory();
	$estLifes = $model->displayEstLife();
	$categories = $model->displayCategories();
	$articles = $model->getArticles();
	$locations = $model->getLocations();
	$units = $model->displayUnits();
	$notes = $model->displayModuleNotes('inventory');
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>


	<title>Inventory | <?php echo $customize['sys_name']; ?></title>

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
			<li class="show" style="margin-top: 0px;">
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
<main class="ttr-wrapper">
	<div class="container-fluid">
		
		 <!-- Header and Button Row -->
		 <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Header aligned to the left -->
                    <h2 class="p-0 mb-0">Inventory</h2>

					<?php if($userInfo['role_id'] == 1): ?>
                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#insert-inventory">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD INVENTORY</span>
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

						<!-- Insert Inventory Record Modal -->
						<div id="insert-inventory" class="modal fade" role="dialog">
							<form class="edit-inventory mb-30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Add Inventory Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<!-- First Column -->
												<div class="form-group col-6">
													<label class="col-form-label">Description</label>
													<textarea class="form-control" name="description" placeholder="Enter property description.." required></textarea>
													
													<label class="col-form-label">Unit</label>
													<select class="form-control" name="unit" required>
														<option value="" selected disabled hidden>-- Select unit of measurement --</option>
														<?php if (!empty($units)): ?>
															<?php foreach ($units as $add_unit): ?>
																<option value="<?php echo $add_unit['id']; ?>"><?php echo $add_unit['unit_name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>

													<label class="col-form-label">Article</label>
													<select class="form-control" name="article" required>
														<option value="" selected disabled hidden>-- Select article --</option>
														<?php if(!empty($articles)):  ?>
															<?php foreach ($articles as $add_article):  ?>
																	
															<option value="<?php echo $add_article['id']; ?>"><?php echo $add_article['article_name']; ?></option>

															<?php endforeach; ?>
														<?php endif; ?>
													</select>

													<label class="col-form-label">Qty per Property Card:</label>
													<input class="form-control" type="number" name="qty_pcard" id="qty_pcard" value="" placeholder="Enter property number" min="1" required oninput="validateInteger(this); updateQtyPcount(this)">
													<small id="qty_pcard_warning" class="text-danger" style="display:none;">Please enter an integer.</small>
												</div>

												<!-- Second Column -->
												<div class="form-group col-6">
													<label class="col-form-label">Category</label>
													<select class="form-control" name="category" required>
														<option value="" selected disabled hidden>-- Select category --</option>
														<?php if (!empty($categories)): ?>
															<?php foreach ($categories as $add_category): ?>
																<option value="<?php echo $add_category['id']; ?>"><?php echo $add_category['category_name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>

													<label class="col-form-label">Location</label>
													<select class="form-control" name="location" required>
														<option value="" selected disabled hidden>-- Select location --</option>
														<?php if (!empty($locations)): ?>
															<?php foreach ($locations as $add_location): ?>
																<option value="<?php echo $add_location['id']; ?>"><?php echo $add_location['location_name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>

													<label class="col-form-label">Estimated Useful Life</label>
													<select class="form-control" name="est_life" required>
													<option value="" selected disabled hidden>-- Select estimated useful life --</option>
														<?php if(!empty($estLifes)): ?>
															<?php foreach ($estLifes as $add_estLife): ?>

																<option value="<?php echo $add_estLife['id']; ?>"><?php echo $add_estLife['est_life']; ?></option>

															<?php endforeach; ?>
														<?php endif; ?>
													</select>

													<label class="col-form-label">Acquisition Date</label>
													<input class="form-control" type="date" name="acquired_date" required max="<?php echo date('Y-m-d'); ?>">
												</div>
											</div>

											<!-- Property Number Section -->
											<div class="form-group col-12">
												<label class="col-form-label">Property Number Type:</label>
												<div class="row">
													<div class="col-xl-6 col-md-12 mb-2">
														<button type="button" class="btn btn-primary my-0 w-100 h-100" onclick="selectPropertyType('unique')">Unique Property Number</button>
													</div>
													<div class="col-xl-6 col-md-12 mb-2">
														<button type="button" class="btn btn-primary my-0 w-100 h-100" onclick="selectPropertyType('single')">Single Property Number</button>
													</div>
												</div>
											</div>

											<!-- Dynamic Inputs for Property Number and Unit Cost -->
											<div id="property-number-container" class="form-group col-12" style="display:none;">
												<div id="property-number-fields"></div>
											</div>
										</div>

										<div class="modal-footer">
											<input type="hidden" name="remark" id="remark" value="4">
											<input type="hidden" name="property_type" id="property_type" value="single">
											<input type="submit" class="btn green radius-xl outline" name="insert-inventory" value="Save Changes">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Insert inventory form -->


						<!-- Inventory table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th width="140">Property No.</th>
										<th class="col-4">Description</th>
										<th lass="col-1">Category</th>
										<th lass="col-1">Remarks</th>
										<th>Date Added</th>
										<?php if($userInfo['role_id'] == 1): ?>
											<th class="col-sm-1 col-lg-2">Action</th>
										<?php else: ?>
											<th class="col-1">Action</th>
										<?php endif; ?>
									</tr>	
								</thead>
								<tbody>
									<?php if (!empty($inventories)): ?>
										<?php foreach ($inventories as $inventory): ?>
											<?php $inv_id = $inventory['inv_id']; ?>

										<tr>
											<td><?php echo $inventory['property_no']; ?></td>
												<td class="description-cell"><?php echo $inventory['description']; ?></td>
												
												<td><?php echo $inventory['category_name']; ?></td>
												<td>
													<?php if(!empty($invNotes = $model->displayInvNotes('inventory', $inventory['remark_name']))): ?>
														<?php foreach ($invNotes as $invNote): ?>
															<span style="font-size: 12px; color: white; padding: 4px; border-radius: 25px; background-color: <?php echo $invNote['color']; ?>;"><?php echo $invNote['note_name']; ?></span>
														<?php endforeach; ?>
													<?php endif; ?>
												</td>
												<td><?php echo date('M. d, Y g:i A', strtotime($inventory['date_added'])); ?></td>

												<td>
													<center>
														<?php if($userInfo['role_id'] == 1): ?>
															<button id="<?php echo $inv_id;?>" onclick="window.location.href='inventory-view.php?id=<?php echo $inventory['inv_id']; ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip" title="View">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</button>
															<button data-toggle="modal" data-target="#update-<?php echo $inv_id; ?>" class="btn blue mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip" title="Update">
																	<i class="ti-marker-alt" style="font-size: 12px;"></i>
																</span>
															</button>
															<button data-toggle="modal" data-target="#archive-<?php echo $inv_id; ?>" class="btn red mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip" title="Archive">
																	<i class="ti-archive" style="font-size: 12px;"></i>
																</span>
															</button>
														<?php else: ?>
															<button id="<?php echo $inv_id;?>" onclick="window.location.href='inventory-view.php?id=<?php echo $inventory['inv_id']; ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip" title="View">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</button>
														<?php endif; ?>
													</center>
												</td>
											</tr>

										
									
											<!-- Update inventory record modal -->
											<div id="update-<?php echo $inv_id; ?>" class="modal fade" role="dialog">
												<form class="edit-inventory m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header"><input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
																<h4 class="modal-title">Update Inventory Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
																	<input type="hidden" name="mainInv_no" value="<?php echo $inventory['inv_id']; ?>">
																	<input type="hidden" name="mainProp_no" value="<?php echo $inventory['property_no']; ?>">
																	<div class="form-group col-6" style="padding-bottom: 15px;">
																		<div class="row">
	
																			<div class="form-group col-12">
																				<label class="col-form-label">Property No.</label>
																				<input class="form-control" type="text" name="property_no" value="<?php echo $inventory['property_no']; ?>" maxlength="18" required>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Description</label>
																				<textarea class="form-control" name="description" required><?php echo $inventory['description']; ?></textarea>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Article</label>
																				<select class="form-control" name="article" required>
																				<?php if(!empty($articles)):  ?>
																					<?php foreach ($articles as $update_article):  ?>

																					<option value="<?php echo $update_article['id']; ?>" <?php if ($inventory['article'] == $update_article['id']) { echo 'selected'; } ?>><?php echo $update_article['article_name']; ?></option>

																					<?php endforeach; ?>
																				<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Acquisition Date</label>
																				<input class="form-control" type="date" name="acquired_date" value="<?php echo $formattedDate = date('Y-m-d', strtotime($inventory['acquisition_date'])); ?>" required id="acquired_date" max="<?php echo date('Y-m-d'); ?>">
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Remarks</label>
																				<select class="form-control" name="remark" required>
																				<?php if(!empty($notes)):  ?>
																					<?php foreach ($notes as $update_note):  ?>

																					<option style="font-size: 14px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $update_note['color']?>;" value="<?php echo $update_note['id']; ?>" <?php if ($inventory['remark'] == $update_note['id']) { echo 'selected'; } ?>><?php echo $update_note['note_name']; ?></option>

																					<?php endforeach; ?>
																				<?php endif; ?>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="form-group col-6" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Category</label>
																				<select class="form-control" name="category" required>
																				<?php if(!empty($categories)):  ?>
																					<?php foreach ($categories as $update_category):  ?>

																					<option value="<?php echo $update_category['id']; ?>" <?php if ($inventory['category'] == $update_category['id']) { echo 'selected'; } ?>><?php echo $update_category['category_name']; ?></option>

																					<?php endforeach; ?>
																				<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Location</label>
																				<select class="form-control" name="location" required>
																				<?php if(!empty($locations)):  ?>
																					<?php if(!empty($inventory['location'])): ?>
																						<?php foreach ($locations as $update_location):  ?>

																						<option value="<?php echo $update_location['id']; ?>" <?php if ($inventory['location'] == $update_location['id']) { echo 'selected'; } ?>><?php echo $update_location['location_name']; ?></option>

																						<?php endforeach; ?>
																					<?php else: ?>
																						<option value="" selected disabled hidden>-- Select location --</option>
																						<?php foreach ($locations as $update_location):  ?>
																									
																							<option value="<?php echo $update_location['id']; ?>"><?php echo $update_location['location_name']; ?></option>
		
																						<?php endforeach; ?>
																					<?php endif; ?>
																				<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Unit</label>
																				<select class="form-control" name="unit" required>
																					<?php if(!empty($units)): ?>
																						<?php foreach ($units as $update_unit): ?>
																						
																						<option value="<?php echo $update_unit['id']; ?>" <?php if ($inventory['unit'] == $update_unit['id']) { echo 'selected'; } ?>><?php echo $update_unit['unit_name']; ?></option>

																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Qty per Property Card:</label>
																				<input class="form-control" type="number" name="qty_pcard" id="qty_pcard" value="<?php echo $inventory['qty_pcard']; ?>" min="<?php echo $inventory['qty_pcount']; ?>" max="9999999" maxlength="9" required readonly>
																				<small id="qty_pcard_warning" class="text-danger" style="display:none;">Please enter an integer.</small>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Qty per Physical Count:</label>
																				<input class="form-control" type="number" name="qty_pcount" id="qty_pcount" value="<?php echo $inventory['qty_pcount']; ?>" min="1" max="9999999" required readonly>
																				<small id="qty_pcount_warning" class="text-danger" style="display:none;">Please enter an integer.</small>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Unit Cost (₱) :</label>
																				<input class="form-control" type="number"  step="0.01" name="cost" value="<?php echo $inventory['unit_cost']; ?>" min="1" max="9999999999.9" required>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Estimated Useful Life</label>
																				<select class="form-control" name="est_life" required>
																					<?php if(!empty($estLifes)): ?>
																						<?php foreach ($estLifes as $update_estLife): ?>

																						<option value="<?php echo $update_estLife['id']; ?>" <?php if ($inventory['estlife_id'] == $update_estLife['id']) { echo 'selected'; } ?>><?php echo $update_estLife['est_life']; ?></option>

																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update-inventory" value="Save Changes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Update inventory record modal -->

											<!-- Archive inventory record modal -->
											<div id="archive-<?php echo $inv_id; ?>" class="modal fade" role="dialog">
												<form id="archive-form-<?php echo $inv_id; ?>" class="edit-profile m-b30" method="POST">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Archive Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
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
																				<input class="form-control" type="text" name="article" value="<?php echo $inventory['article_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Acquisition Date</label>
																				<input class="form-control" type="date" name="acquired_date" value="<?php echo $formattedDate = date('Y-m-d', strtotime($inventory['acquisition_date'])); ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Remarks</label>
																				<input class="form-control" type="text" name="remark" value="<?php echo $inventory['remark_name']; ?>" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="form-group col-6" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Category</label>
																				<input class="form-control" type="text" name="category" value="<?php echo $inventory['category_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Location</label>
																				<input class="form-control" type="text" name="location" value="<?php echo $inventory['location_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Unit</label>
																				<input class="form-control" type="text" name="unit" value="<?php echo $inventory['unit_name']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Qty per Property Card:</label>
																				<input class="form-control" type="number" name="qty_pcard" id="qty_pcard-<?php echo $inv_id; ?>" value="<?php echo $inventory['qty_pcard']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Qty per Physical Count:</label>
																				<input class="form-control" type="number" name="qty_pcount" id="qty_pcount-<?php echo $inv_id; ?>" value="<?php echo $inventory['qty_pcount']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Unit Cost (₱) :</label>
																				<input class="form-control" type="number" step="0.01" name="cost" id="cost" value="<?php echo $inventory['unit_cost']; ?>" readonly>
																			</div>
																			<div class="form-group col-12">
																				<label class="col-form-label">Estimated Useful Life</label>
																				<input class="form-control" type="text" name="est_life" value="<?php echo $inventory['est_life']; ?>" readonly>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="archive-inventory" value="Archive" onClick="return validateQty(<?php echo $inv_id; ?>)">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Archive inventory record modal -->

										<?php endforeach; ?> <!-- table data end foreach -->
									<?php endif; ?> <!-- table data end if -->
								</tbody>
							</table>
						</div> <!-- table-responsive -->

						<?php	

							/* Insert inventory record controller */	
							if (isset($_POST['insert-inventory'])) {
								$article = $_POST['article'];
								$acquired_date = $_POST['acquired_date'];
								$description = $_POST['description'];
								$category = $_POST['category'];
								$location = $_POST['location'];
								$unit = $_POST['unit'];
								$qty_pcard = $_POST['qty_pcard'];
								$est_life = $_POST['est_life'];
								$remark = $_POST['remark'];
								$property_type = $_POST['property_type'];
							
								// Check if 'Single' or 'Unique' property number was selected
								if ($property_type === 'single') {
									$property_no = $_POST['property_no'];
									$cost = $_POST['cost']; // Add this line to fetch cost
									$qty_pcount = $_POST['qty_pcard'];
								
									if (!$model->checkPropertyNoExist($property_no)) {
										$model->insertInventory($property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark);
										$_SESSION['successMessage'] = "Inventory record added successfully!";
										header("Location: inventory.php");
										exit();
									} else {
										$_SESSION['errorMessage'] = "Property No. '". $property_no ."' already exists!";
										header("Location: inventory.php");
										exit();
									}
									
								} elseif ($property_type === 'unique') { 
									$allInserted = true;
									$existingPropertyNumbers = []; // Track existing property numbers
									
									for ($i = 1; $i <= $qty_pcard; $i++) { 
										$property_no = $_POST["property_no_$i"] ?? null; 
										$cost = $_POST["cost_$i"] ?? null;  
										
										// Check for missing property number or cost
										if (empty($property_no) || empty($cost)) {
											$allInserted = false;
											$_SESSION['errorMessage'] = "Property No. or Cost missing for item $i.";
											header("Location: inventory.php");
											exit();
										}
								
										// Check for duplicates within the current batch
										if (in_array($property_no, $existingPropertyNumbers)) {
											$allInserted = false;
											$_SESSION['errorMessage'] = "Duplicate Property No. in current batch: " . $property_no;
											header("Location: inventory.php");
											exit();
										}
								
										// Check database for existing property number
										if (!$model->checkPropertyNoExist($property_no)) { 
											$model->insertInventory($property_no, $category, $location, $article, $description, 1, 1, $unit, $cost, $est_life, $acquired_date, $remark); 
											$existingPropertyNumbers[] = $property_no; // Add to tracked numbers
										} else { 
											$allInserted = false; 
											$_SESSION['errorMessage'] = "Property No. ". $property_no ." already exists in database!"; 
											header("Location: inventory.php"); 
											exit(); 
										} 
									} 
									
									if ($allInserted) {
										$_SESSION['successMessage'] = "Inventory records added successfully!";
										header("Location: inventory.php"); 
										exit(); 
									}
								}
								
								
							}
							
							/* Update inventory record controller */
							if (isset($_POST['update-inventory'])) {
								$inv_id = $_POST['inv_id'];
								$main_inv_id = $_POST['mainInv_no'];
								$main_prop_no = $_POST['mainProp_no'];
								$property_no = $_POST['property_no'];
								$article = $_POST['article'];
								$acquired_date = $_POST['acquired_date'];
								$description = $_POST['description'];
								$category = $_POST['category'];
								$location = $_POST['location'];
								$unit = $_POST['unit'];
								$qty_pcard = $_POST['qty_pcard'];
								$qty_pcount = $_POST['qty_pcount'];
								$cost = $_POST['cost'];
								$est_life = $_POST['est_life'];
								$remark = $_POST['remark'];
							
								// Fetch old values
								$oldValues = $model->getInventoryByInvId($inv_id);
								$oldRemark = $oldValues['note_name'];
							
								$remarkDetail = $model->getNoteDetailByID($remark);
								$newRemark = $remarkDetail['note_name'];
								$checkPropertyNoExist = $model->checkPropertyNoExist($property_no);
								$checkPropertyNoAssignment = $model->checkPropertyNoAssignment($property_no);
								
								// Check if remark is updated and item is not assigned
								if(!$checkPropertyNoAssignment) {
									// Inventory No. should not already exist or should be the same
									if ($main_inv_id == $inv_id) {
										// Property No. should not already exist or should be the same.
										if(!$checkPropertyNoExist || $main_prop_no == $property_no) {
											$model->updateInventory($property_no, $article, $description, $category, $location, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark, $inv_id);
							
											$model->logTransactionInventoryUpdate($oldValues, $_POST);
											
											$_SESSION['successMessage'] = "Inventory record updated successfully!";
											header("Location: inventory.php");
											exit();
										} else {
											$_SESSION['errorMessage'] = "Property No. already exist!";
											header("Location: inventory.php");
											exit();
										}
									} else {
										$_SESSION['errorMessage'] = "Inventory No. already exist!";
										header("Location: inventory.php");
										exit();
									} 
								} else {
									$_SESSION['errorMessage'] = "Updating remark unsuccessful. Inventory is still assigned to end user or update not allowed.";
									header("Location: inventory.php");
									exit();
								}
							}

							/* Archive inventory record controller */
							if (isset($_POST['archive-inventory'])) {
								$inv_id = $_POST['inv_id'];
								$model->archiveInventory($inv_id);

								$_SESSION['successMessage'] = "Inventory record archived successfully!";
								header("Location: inventory.php");
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
	
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#table').DataTable({
				order: [[4, 'desc']], // Sort by the 2nd column (Date & Time) in descending order
				columnDefs: [
					{ orderable: false, targets: 2 } // Disable sorting for the Action column
				]
			});

			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>

	<script>
		let selectedType = "";

		function selectPropertyType(type) {
			selectedType = type;
			document.getElementById("property_type").value = type; // Set hidden input
			document.getElementById("property-number-container").style.display = "block";
			updatePropertyNumberFields();
		}

		function updatePropertyNumberFields() {
			const qty = parseInt(document.getElementById("qty_pcard").value) || 0;
			const container = document.getElementById("property-number-fields");
			container.innerHTML = ""; // Clear existing inputs

			if (selectedType === "unique") {
				for (let i = 1; i <= qty; i++) {
					const row = document.createElement("div");
					row.className = "row mb-2";

					const propertyInput = document.createElement("div");
					propertyInput.className = "col-6";
					propertyInput.innerHTML = `<input class="form-control" type="text" name="property_no_${i}" placeholder="Property Number ${i}" required>`;

					const costInput = document.createElement("div");
					costInput.className = "col-6";
					costInput.innerHTML = `<input class="form-control" type="number" name="cost_${i}" placeholder="Unit Cost (₱)" step="0.01" required>`;

					row.appendChild(propertyInput);
					row.appendChild(costInput);
					container.appendChild(row);
				}
			} else if (selectedType === "single") {
			const row = document.createElement("div");
			row.className = "row";

			const propertyInput = document.createElement("div");
			propertyInput.className = "col-6";
			propertyInput.innerHTML = `<input class="form-control" type="text" name="property_no" placeholder="Property Number" required>`;

			const costInput = document.createElement("div");
			costInput.className = "col-6";
			costInput.innerHTML = `<input class="form-control" type="number" name="cost" placeholder="Unit Cost (₱)" step="0.01" required>`;

			row.appendChild(propertyInput);
			row.appendChild(costInput);
			container.appendChild(row);
		}

		}

		document.getElementById("qty_pcard").addEventListener("input", updatePropertyNumberFields);

	</script>

			<!-- Input in number input -->
	<script>
		function validateInteger(input) {
		const warningElement = document.getElementById(`${input.id}_warning`);
		// Check if the value is a valid integer
			if (Number.isInteger(Number(input.value)) || input.value === '') {
				warningElement.style.display = 'none'; // Hide warning if valid
				input.setCustomValidity(''); // Clear custom validity
			} else {
				warningElement.style.display = 'block'; // Show warning if invalid
				input.setCustomValidity('Please enter an integer.'); // Set custom validity message
			}
		}
	</script>
      
</body>

</html>