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
		$endUsers = $model->getEndUser();

	}
	
?>

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

		<!-- Header title and buttons -->
		<div class="ttr-main-header">
			<div class="float-left">
				<h2 class="title-head float-left">Inventory Assignment<span style="font-weight: normal;"> - Details</span></h2>
			</div>

			<!-- Transfer property assignment button -->
			<div>
				<?php if(canUpdateAssignment()): ?>
				<form  method="post">
					<button type="button" class="btn red radius-xl float-right" data-toggle="modal" data-target="#insert-assignment"><i class="fa fa-plus"></i><span data-toggle="tooltip">&nbsp;&nbsp;TRANSFER</span></button>
				</form>
				<?php endif; ?>
			</div> 
			
			 <br><br><br>
		</div> <!-- Header title and buttons -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<!-- <div id="preloader"></div> -->

					<!-- Download to excel button -->
					<div class="row me-1 mt-3" style="float: right;">
						<form action="report/assignment-transfer-excel.php" method="post">
							<input type="hidden" class="form-control form-control-sm" name="transfer_id" value="<?php echo $transfer_id; ?>" />
							<input type="hidden" name="session_name" value="<?php echo $_SESSION['session_name']; ?>" /> <!-- Ensure session name is set -->
							<button class="btn blue green btn-xs radius-xl" id="assignment-transfer-excel" name="assignment-transfer-excel">
								<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
							</button>
						</form>
					</div> <!-- Download to excel button -->
					<br><br>

					<div class="widget-inner">
						
						<div class="row" width="100%">
							
							<div class="form-group col-6">
								<label class="col-form-label">New Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $assignment_details['new_username'] ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">Date Transferred</label>
								<input class="form-control" name="description" value="<?php echo date('F d, Y', strtotime($assignment_details['date_transferred'])); ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">Old Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $assignment_details['old_username'] ?>" readonly>
							</div>
							&nbsp;
							<div class="mt-5"></div>		
							
							<!-- table -->
							<table class="table table-striped table-hover"style="width:100%">
								<thead>
									<tr>
										<th>Propert No.</th>
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

							<!-- Insert inventory assignment modal or forms-->
							<div id="insert-assignment" class="modal fade" role="dialog">
								<form class="insert-assignment m-b30" method="POST" enctype="multipart/form-data">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<input type="hidden" name="transfer_id" value="<?php echo $transfer_id; ?>">
												<input type="hidden" name="oldEndUser" value="<?php echo $assignment_details['new_end_user']; ?>">
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
																			<?php if($endUser['id'] != $assignment_details['new_end_user']): ?>

																			<option value="<?php echo $endUser['id']; ?>"><?php echo $endUser['username']; ?></option>

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
							</div> <!-- Insert inventory assignment modal or forms-->

							
						
							<?php

								/* Insert new assignment record controller */
								if (isset($_POST['transfer-assignment'])) {
									$newEndUser = $_POST['newEndUser'];
									$oldEndUser = $_POST['oldEndUser'];
									$fromAssignmentId = $_POST['transfer_id'];
								
									// Insert the new assignment transfer record
									$newAssignmentId = $model->insertAssignmentTransfer($newEndUser, $oldEndUser);
								
									// Redirect to inventory-assignment-transfer.php with the new and old assignment IDs
									echo "<script>window.open('inventory-assignment-transfer-transfer.php?new_id=$newAssignmentId&old_id=$fromAssignmentId', '_self');</script>";
								}
								
							?>
							
						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->

<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/footer.php') ?>