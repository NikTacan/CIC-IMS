<?php include('../includes/session.php'); ?>
<?php include('../includes/layouts/main-layouts/html-head.php') ?>

<?php	

	if (isset($_GET['id'])) {
		$inv_id = $_GET['id'];
		$InvIDDetail = $model->getInventoryByInvNo($inv_id);
		$notes = $model->displayModuleNotes('inventory');
		$property_no = $InvIDDetail['property_no'];
		
	} else {
		echo '<h3 class="text-center">Inventory ID not provided.</h3>';
		echo '<div class="text-center"><a href="index.php" class="btn btn-primary">Back</a></div>';
		exit;
	} 

	if (empty($InvIDDetail)) {
		echo '<div><h3 class="text-center">Data not found.</h3>';
		echo '<div class="text-center"><a href="index" class="btn btn-primary">Back</a></div></divr';
		exit;
	}
?>


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
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="row">

			<!-- Inventory-detail -->
			<div class="inventory-detail col-md-5 mt-0" style="margin: left 0;"> 	
				<div class="ttr-container-header row col-lg-12 m-b20 px-0">
					<div class="d-flex justify-content-between align-items-center mx-0 px-0">
						<h2 class="ms-2 p-0 my-0">Inventory<span style="font-weight: normal;"> Details</span></h2>
					</div>
				</div>
				<div class="row">
					<div class="widget-box ">
						<div class="widget-inner">      
							<div class="row">

								<h3>
									<?php echo $InvIDDetail['description']; ?>
									<br><span class="h5"><?php echo $InvIDDetail['property_no']; ?></span>
								</h3>
								<table class="table">
									<tr>
										<th scope="col">Article</th>
										<td class="text-end"><?php echo $InvIDDetail['article_name']; ?></td>
									</tr>
									<tr>
										<th scope="col">Acquisition Date</th>
										<td class="text-end"><?php echo date('F d, Y', strtotime($InvIDDetail['acquisition_date'])); ?></td>
									</tr>
									<tr>
										<th scope="col">Category</th>
										<td class="text-end"><?php echo $InvIDDetail['category_name']; ?></td>
									</tr>
									<tr>
										<th scope="col">Location</th>
										<td class="text-end"><?php echo $InvIDDetail['location_name']; ?></td>
									</tr>
									<tr>
										<th scope="col">Property No.</th>
										<td class="text-end"><?php echo $InvIDDetail['property_no']; ?></td>
									</tr>
									<tr>
										<th scope="row">Unit of Measurement</th>
										<td class="text-end"> <?php echo $InvIDDetail['unit_name']; ?></td>
									</tr>
									<tr>
										<th scope="row">Unit Value</th>
										<td class="text-end"><?php echo number_format($InvIDDetail['unit_cost'], 2, '.', ','); ?></td>
									</tr>
									<tr>
										<th scope="row">Qty per Property Card</th>
										<td class="text-end"><?php echo $InvIDDetail['qty_pcard']; ?></td>
									</tr>
									<tr>
										<th scope="row">Qty per Physical Count</th>
										<td class="text-end"><?php echo $InvIDDetail['qty_pcount']; ?></td>
									</tr>
									<tr>
										<th scope="row">Estimate Useful Life</th>
										<td class="text-end"> <?php echo $InvIDDetail['est_life']; ?></td>
									</tr>
									<tr>
										<th scope="row">Remarks</th>
										<td class="text-end">
											<?php if(!empty($notes = $model->displayInvNotes('inventory', $InvIDDetail['note_name']))): ?>
												<?php foreach ($notes as $note): ?>
												<span style="font-size: 12px; color: white; padding: 4px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
												<?php endforeach; ?>
											<?php endif; ?>
										</td>
									</tr>		
								</table>

							</div> <!-- row -->
						</div> <!-- widger-inner -->
					</div> <!-- widget-box --> 
				</div> <!-- row -->
			</div> <!-- inventory-detail -->

			<!-- inventory-view-2 -->
			<div class="inventory-view-2 col-md-7"> 
				<div class="divider ms-3">

					<!-- inventory-assignment -->
					<div class="inventory-details">
						<div class="ttr-container-header row col-lg-12 m-b20 px-0">
							<div class="d-flex justify-content-between align-items-center mx-0 px-0">
								<h2 class="ms-2 p-0 my-0">Assignment<span style="font-weight: normal;"> History</span></h2>
							</div>
						</div>
					
						<div class="row">
							<div class="widget-box ">
								<div class="widget-inner">

									<!-- inventory-assignment table -->
									<div class="table-responsive">
										<table id="table" class="table" style="width:100%">
											<thead>
												<tr>
													<th class="col-5">Assigned</th>
													<th>Qty</th>
													<th>Date Added</th>
													<th class="col-1">Action</th>
												</tr>
											</thead>
											<tbody>

												<?php if(!empty($assignments = $model->displayPropertyAsssignments($InvIDDetail['property_no']))): ?>
													<?php foreach ($assignments as $assignment): ?>
													<?php $assignment_id = $assignment['assignment_id']; ?>
													<tr>
														<td><?php echo $assignment['username']; ?></td>
														<td><?php echo $assignment['qty']; ?></td>
														<td><?php echo date('M. d, Y g:i A', strtotime($assignment['date_added'])); ?></td>
														<td>
															<button onclick="window.location.href='inventory-assignment-view.php?id=<?php echo $assignment_id?>'" type="submit" name="view" class="btn green" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</button>
														</td>	
													</tr>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if(!empty($transferRecord = $model->displayPropertyTransfer($InvIDDetail['property_no']))): ?>
													<?php foreach ($transferRecord as $transfer): ?>
													<?php $transfer_id = $transfer['transfer_id']; ?>
													<tr>
														<td><?php echo $transfer['username']; ?></td>
														<td><?php echo $transfer['qty']; ?></td>
														<td>
															<span style="font-size: 10px; color: white; padding: 5px; border-radius: 25px; background-color: red;">Transferred</span>
														</td>
														<td><?php echo date('F d, Y', strtotime($transfer['date_transferred'])); ?></td>
														<td>
															<button onclick="window.location.href='inventory-assignment-transfer-view.php?id=<?php echo $transfer_id?>'" type="submit" name="view" class="btn green" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</button>
														</td>	
													</tr>
													<?php endforeach; ?>
												<?php endif; ?>

											</tbody>
										</table>
									</div> <!-- inventory-assignment table-->

								</div> <!-- widget-inner -->
							</div> <!-- widget-box -->
						</div> <!-- row -->
					</div> <!-- inventory-assignment -->

					<!-- Inventory-history -->
					<div class="inventory-history mt-4">
						<div class="ttr-container-header row col-lg-12 m-b20 px-0">
							<div class="d-flex justify-content-between align-items-center mx-0 px-0">
								<h2 class="ms-2 p-0 my-0">Inventory<span style="font-weight: normal;"> Logs</span></h2>
							</div>
						</div>	
						<div class="row">
							<div class="widget-box ">
								<div class="widget-inner">

									<!-- inventory-assignment -->
									<div class="table-responsive">
										<table id="table-2" class="table">
											<thead>
												<tr>
													<th class="col-9">Activity</th>
													<th>Date & Time</th>
												</tr>
											</thead>
											<tbody>
												
												<?php if(!empty($InvLogs = $model->displayInvNoLog($inv_id, 'inventory'))): ?>
													<?php foreach ($InvLogs as $LogICS ): ?>
													<tr>
														<td><span class="text-bold">
																<?php echo mb_strimwidth($LogICS['description'], 0, 30, '...'); ?>
															</span>
															<span class="text-normal"><?php echo $LogICS['log_message']; ?></span>
														</td>
														<td><?php echo date('M d, Y g:i A', strtotime($LogICS['date_time'])); ?></td>
													</tr>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if(!empty($InvLogs = $model->displayInvNoLog($property_no))): ?>
													<?php foreach ($InvLogs as $LogPAR ): ?>
													<tr>
														<td><span class="text-bold">
																<?php echo mb_strimwidth($LogPAR['description'], 0, 30, '...'); ?>
															</span>
															<span class="text-normal"><?php echo $LogPAR['log_message']; ?></span>
														</td>
														<td><?php echo date('M d, Y g:i A', strtotime($LogPAR['date_time'])); ?></td>
													</tr>
													<?php endforeach; ?>
												<?php endif; ?> 
												
											</tbody>
										</table>
									</div> <!-- inventory-assignment table-->

								</div> <!-- widget-inner -->
							</div> <!-- widget-box -->
						</div> <!-- row -->
					</div> <!-- inventory-history -->

				</div>	<!-- divider ms-3 -->
			</div> <!-- inventory-view-2 -->
			
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<!-- header & styles -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

</body>

</html>