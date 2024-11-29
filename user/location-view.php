<?php include('../includes/session.php'); ?>

<?php 
	if (isset($_GET['location'])) {
    	$location = $_GET['location'];
    	$inventoryItems = $model->getInventoryByLocation($end_user_id, $location);
	}
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Location | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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

		<div class="ttr-container-header row col-lg-12 mb-3">
			<div class="d-flex justify-content-between mx-0 px-0">
				<div class="float-left">
					<h2 class="p-0 ms-2 mb-0">Location<span style="font-weight: normal;">Details</span></h2>
				</div>
			</div>
		</div>

		<div class="widget-box">
			<div id="preloader"></div>
			<div class="widget-inner">
				<div class="row" width="100%">
							
					<!-- Header title -->
					<h2 class="text-center"><?php echo $location ?></h2>
					
					<div class="mt-3"></div>	
					<div class="table-responsive">
						<table id="table" class="table table-striped table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Property No.</th>
									<th class="col-4">Description</th>
									<th>Quantity</th>
									<th>Unit</th>
									<th>Acquisition Date</th>
									<th class="col-1">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($inventoryItems)): ?>
									<?php foreach ($inventoryItems as $invloc_row): ?>
										<?php $item_id = $invloc_row['item_id']; ?>
									<tr>
										<td><?php echo $invloc_row['property_no']; ?></td>
										<td>
											<?php
												$words = explode(' ', $invloc_row['description']);

												echo implode(' ', array_slice($words, 0, 7));
											?>
										</td>
										<td><?php echo $invloc_row['qty']; ?></td>
										<td><?php echo $invloc_row['unit']; ?></td>
										<td><?php echo $invloc_row['acquisition_date']; ?></td>
										<td>
											<center>
												<button id="<?php echo $item_id;?>" onclick="window.location.href='inventory-view.php?id=<?php echo $item_id; ?>'" type="submit" name="view" class="btn green" style="width: 50px; height: 37px;">
													<span data-toggle="tooltip">
														<i class="ti-search" style="font-size: 12px;"></i>
													</span>
												</button>
										</center>
										</td>
									</tr>

									<?php endforeach; ?>
								<?php endif; ?> <!-- inventory location table data endif -->

							</tbody>	
						</table> 
					</div>	<!-- table-responsive -->

				</div> <!-- row -->
			</div> <!-- widget-inner -->
		</div> <!-- widget-box -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	<?php include('../includes/js/preloader.php'); ?>

</body>
</html>