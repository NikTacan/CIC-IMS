<?php include('../includes/session.php'); ?>

<?php	
	if (isset($_GET['id'])) {
		$assignment_id = $_GET['id'];
		$InvIDDetail = $model->getEndUserInventoryInfo($assignment_id);
		$property_no = $InvIDDetail['property_no'];
	} else {
		echo '<h3 class="text-center">Inventory ID not provided.</h3>';
		echo '<div class="text-center"><a href="history.php" class="btn btn-primary">Back</a></div>';
		exit;
	} 
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
										<th scope="col">Acquisition Date</th>
										<td class="text-end"><?php echo date('F d, Y', strtotime($InvIDDetail['acquisition_date'])); ?></td>
									</tr>
									<tr>
										<th scope="col">Location</th>
										<td class="text-end"><?php echo $InvIDDetail['location']; ?></td>
									</tr> 
									<tr>
										<th scope="row">Unit of Measurement</th>
										<td class="text-end"> <?php echo $InvIDDetail['unit']; ?></td>
									</tr>
									<tr>
										<th scope="row">Quantity</th>
										<td class="text-end"><?php echo $InvIDDetail['qty']; ?></td>
									</tr>
									<tr>
										<th scope="row">Unit Value</th>
										<td class="text-end"><?php echo number_format($InvIDDetail['unit_cost'], 2, '.', ','); ?></td>
									</tr>
									<tr>
										<th scope="row">Total Amount</th>
										<td class="text-end"><?php echo number_format($InvIDDetail['total_cost'], 2, '.', ','); ?></td>
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

					
					<!-- Inventory-history --> 
					<div class="inventory-history">
						<div class="ttr-container-header row col-lg-12 m-b20 px-0">
							<div class="d-flex justify-content-between align-items-center mx-0 px-0">
								<h2 class="ms-2 p-0 my-0">Inventory<span style="font-weight: normal;"> Logs</span></h2>
							</div>
						</div>	
						<div class="row">
							<div class="widget-box ">
								<div class="widget-inner">

									
									<div class="table-responsive">
										<table id="table-2" class="table">
											<thead>
												<tr>
													<th class="col-9">Activity</th>
													<th>Date & Time</th>
												</tr>
											</thead>
											<tbody>
												
												<?php /* if(!empty($InvLogs = $model->displayInvNoLog($inv_id, 'inventory'))): ?>
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
												<?php endif; */ ?> 
												
											</tbody>
										</table>
									</div> <!-- inventory-assignment table -->

								</div> <!-- widget-inner -->
							</div> <!-- widget-box -->
						</div> <!-- row -->
					</div> <!-- inventory-history -->

				</div>	<!-- divider ms-3 -->
			</div> <!-- inventory-view-2 -->
			
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

</body>
</html>