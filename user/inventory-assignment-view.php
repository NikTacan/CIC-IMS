<?php include('../includes/session.php'); ?>

<?php
	if (isset($_GET['id'])) {
		$assignment_id = $_GET['id'];
		$assignment_details = $model->getAssignmentDetailById($assignment_id);
		$assignment_items = $model->getAssignmentItemsById($assignment_id);
		$endUserId = $assignment_details['end_user_id'];
		$qty = $model->getAssignmentItemQty($assignment_id);
	}
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

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
                    <h2 class="p-0 mb-0">Inventory Assignment <span style="font-weight: normal;">Details</span></h2>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div id="preloader"></div>
					<div class="widget-inner">
						
						<div class="row" width="100%">
							
							<div class="form-group col-6">
								<label class="col-form-label">Accountable End User</label>
								<input class="form-control" name="end_user" value="<?php echo $assignment_details['username'] ?>" readonly>
							</div>
							<div class="form-group col-6">
								<label class="col-form-label">Date Added</label>
								<input class="form-control" name="description" value="<?php echo date('F d, Y g:i A', strtotime($assignment_details['date_added'])); ?>" readonly>
							</div>&nbsp;
							<div class="mt-5"></div>		
							
							<!-- table -->
							<table id="assignment-table" class="table table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<th>Property No.</th>
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
							
						</div> <!-- row -->
						
							
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- Container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	<?php include('../includes/js/preloader.php'); ?>

</body>
</html>