<?php include('../includes/session.php'); ?>

<?php
	$assignments = $model->getInventoryAssignmentByEndUserId($end_user_id);

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
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
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
                    <h2 class="p-0 mb-0">Inventory Assignment</h2>
                </div>
            </div>
        </div>          


		<div class="row">
			<div class="col-lg-12">
				<div class="widget-box">
					<div class="widget-inner">
						<div style="padding: 10px;"></div>	

						<!-- Inventory Assigment table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-2">End User</th>
										<th class="col-1">Assigned Items</th>
										<th class="col-1">Status</th>
										<th class="col-2">Date Added</th>
										<th class="col-sm-1 col-lg-1">Action</th>
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
											<td><?php echo $assignment['username']; ?></td>
											<td><?php echo $totalQty; ?></td>
											<td>	
												<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: green;">Assigned</span>		
											</td>
											<td><?php echo date('F d, Y g:i A', strtotime($assignment['date_added'])); ?></td>
											<td>
												<center>
														<button id="<?php echo $assignment_id; ?>" onclick="window.location.href='inventory-assignment-view.php?id=<?php echo $assignment_id ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="View">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
												</center>
											</td>
										</tr>

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
								
								echo "<script>alert('Assignment record has been archived!');window.open('inventory-assignment', '_self')</script>";
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

</body>
</html>